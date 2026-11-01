<?php

namespace App\Http\Controllers;

use App\Models\Yacht;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class YachtController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'type' => ['nullable', Rule::in(['motor', 'sailing'])],
            'guests' => ['nullable', 'integer', 'between:1,12'],
            'budget' => ['nullable', 'integer', 'between:1,1000000000'],
        ]);

        $yachts = Yacht::query()
            ->where('is_published', true)
            ->when($filters['q'] ?? null, function (Builder $query, string $term): void {
                $query->where(function (Builder $query) use ($term): void {
                    $query->where('name', 'like', "%{$term}%")
                        ->orWhere('description', 'like', "%{$term}%")
                        ->orWhere('overview', 'like', "%{$term}%");
                });
            })
            ->when($filters['type'] ?? null, fn (Builder $query, string $type) => $query->where('type', $type))
            ->when($filters['guests'] ?? null, fn (Builder $query, int $guests) => $query->where('guest_capacity', '>=', $guests))
            ->when($filters['budget'] ?? null, fn (Builder $query, int $budget) => $query->where('weekly_rate_usd', '<=', $budget))
            ->orderBy('name')
            ->paginate(9)
            ->withQueryString();

        return view('yachts.index', compact('yachts', 'filters'));
    }

    public function show(Yacht $yacht): View
    {
        abort_unless($yacht->is_published, 404);

        return view('yachts.show', compact('yacht'));
    }
}
