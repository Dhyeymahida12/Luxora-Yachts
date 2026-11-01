<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Yacht;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class YachtController extends Controller
{
    public function index(): View
    {
        return view('admin.yachts.index', [
            'yachts' => Yacht::query()->orderBy('name')->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('admin.yachts.form', [
            'yacht' => new Yacht,
            'images' => $this->imageOptions(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $yacht = Yacht::create($this->validatedYacht($request));

        return redirect()
            ->route('admin.yachts.edit', $yacht)
            ->with('status', 'Yacht profile created.');
    }

    public function edit(Yacht $yacht): View
    {
        return view('admin.yachts.form', [
            'yacht' => $yacht,
            'images' => $this->imageOptions(),
        ]);
    }

    public function update(Request $request, Yacht $yacht): RedirectResponse
    {
        $yacht->update($this->validatedYacht($request, $yacht));

        return back()->with('status', 'Yacht profile updated.');
    }

    public function destroy(Yacht $yacht): RedirectResponse
    {
        $yacht->delete();

        return redirect()
            ->route('admin.yachts.index')
            ->with('status', 'Yacht profile deleted.');
    }

    private function validatedYacht(Request $request, ?Yacht $yacht = null): array
    {
        $images = $this->imageOptions();
        if ($yacht !== null) {
            $images[] = $yacht->image;
        }

        $validated = $request->validate([
            'slug' => ['required', 'string', 'alpha_dash', 'max:180', Rule::unique('yachts', 'slug')->ignore($yacht?->id)],
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', Rule::in(['motor', 'sailing'])],
            'image' => [$yacht === null ? 'required_without:image_file' : 'nullable', 'nullable', 'string', Rule::in($images)],
            'image_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'extensions:jpg,jpeg,png,webp', 'dimensions:min_width=500,min_height=300,max_width=6000,max_height=6000', 'max:8192'],
            'length_m' => ['required', 'numeric', 'between:1,200'],
            'guest_capacity' => ['required', 'integer', 'between:1,30'],
            'cabins' => ['required', 'integer', 'between:1,30'],
            'crew_size' => ['nullable', 'integer', 'between:1,100'],
            'build_year' => ['required', 'integer', 'between:1900,'.(now()->year + 2)],
            'max_speed_knots' => ['nullable', 'integer', 'between:1,100'],
            'cruising_speed_knots' => ['nullable', 'integer', 'between:1,100'],
            'range_nm' => ['nullable', 'integer', 'between:1,100000'],
            'weekly_rate_usd' => ['nullable', 'integer', 'between:1,1000000000'],
            'description' => ['required', 'string', 'max:1000'],
            'overview' => ['required', 'string', 'max:3000'],
            'cruising_regions' => ['required', 'string', 'max:2000'],
            'amenities' => ['required', 'string', 'max:2000'],
            'is_illustrative' => ['sometimes', 'boolean'],
            'is_published' => ['sometimes', 'boolean'],
        ]);

        $image = $request->file('image_file');
        $validated['image'] = $image !== null
            ? 'storage/'.$image->store('yachts', config('admin.upload_disk'))
            : ($validated['image'] ?? $yacht?->image);

        $validated['cruising_regions'] = $this->linesToList($validated['cruising_regions']);
        $validated['amenities'] = $this->linesToList($validated['amenities']);
        $validated['is_illustrative'] = $request->boolean('is_illustrative');
        $validated['is_published'] = $request->boolean('is_published');
        unset($validated['image_file']);

        return $validated;
    }

    private function imageOptions(): array
    {
        $paths = glob(public_path('images/*')) ?: [];

        return collect($paths)
            ->filter(fn (string $path): bool => in_array(strtolower(pathinfo($path, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'webp'], true))
            ->map(fn (string $path): string => basename($path))
            ->values()
            ->all();
    }

    private function linesToList(string $input): array
    {
        return collect(preg_split('/\R/u', $input) ?: [])
            ->map(fn (string $value): string => trim($value))
            ->filter()
            ->values()
            ->all();
    }
}
