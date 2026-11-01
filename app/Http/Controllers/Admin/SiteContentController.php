<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PageController;
use App\Models\SiteContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SiteContentController extends Controller
{
    public function index(): View
    {
        $pages = PageController::editableContentPages();
        $savedContent = SiteContent::query()
            ->whereIn('page_key', array_keys($pages))
            ->get()
            ->keyBy('page_key');

        foreach ($pages as $key => $page) {
            $pages[$key]['content'] = array_merge(
                $page['content'],
                $savedContent->get($key)?->content ?? [],
            );
        }

        return view('admin.content.index', compact('pages'));
    }

    public function edit(string $page): View
    {
        $pages = PageController::editableContentPages();
        abort_unless(isset($pages[$page]), 404);

        $content = array_merge(
            $pages[$page]['content'],
            SiteContent::query()->where('page_key', $page)->first()?->content ?? [],
        );

        return view('admin.content.edit', [
            'pageKey' => $page,
            'label' => $pages[$page]['label'],
            'content' => $content,
            'images' => $this->imageOptions(),
        ]);
    }

    public function update(Request $request, string $page): RedirectResponse
    {
        $pages = PageController::editableContentPages();
        abort_unless(isset($pages[$page]), 404);

        $defaults = $pages[$page]['content'];
        $current = array_merge(
            $defaults,
            SiteContent::query()->where('page_key', $page)->first()?->content ?? [],
        );
        $images = [...$this->imageOptions(), $current['image']];
        $rules = [
            'headline' => ['required', 'string', 'max:240'],
            'description' => ['required', 'string', 'max:2000'],
            'image' => ['nullable', 'string', Rule::in($images)],
            'image_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'extensions:jpg,jpeg,png,webp', 'dimensions:min_width=500,min_height=300,max_width=6000,max_height=6000', 'max:8192'],
        ];

        foreach (['eyebrow' => 100, 'story_title' => 180, 'story_description' => 2000] as $field => $maxLength) {
            if (array_key_exists($field, $defaults)) {
                $rules[$field] = ['required', 'string', 'max:'.$maxLength];
            }
        }

        $validated = $request->validate($rules);
        $image = $request->file('image_file');

        if ($image !== null) {
            $validated['image'] = 'storage/'.$image->store('admin-images', config('admin.upload_disk'));
        }

        unset($validated['image_file']);
        $content = array_merge(
            $current,
            array_intersect_key($validated, $defaults),
        );

        SiteContent::query()->updateOrCreate(
            ['page_key' => $page],
            ['content' => $content],
        );

        return redirect()
            ->route('admin.content.index')
            ->with('status', $pages[$page]['label'].' page content updated.');
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
}
