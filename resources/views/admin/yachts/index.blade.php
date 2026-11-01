@extends('admin.layout')
@section('title', 'Yacht profiles | Luxora Admin')

@section('content')
    <div class="admin-page-heading">
        <div>
            <p class="admin-eyebrow">COLLECTION</p>
            <h1>Yacht profiles</h1>
            <p>Manage specifications, images and publication status.</p>
        </div>
        <a class="admin-button" href="{{ route('admin.yachts.create') }}">Add yacht</a>
    </div>

    <section class="admin-panel">
        @if ($yachts->isNotEmpty())
            <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead><tr><th>Yacht</th><th>Style</th><th>Guests</th><th>Example weekly rate</th><th>Visibility</th><th></th></tr></thead>
                    <tbody>
                        @foreach ($yachts as $yacht)
                            <tr>
                                <td class="admin-yacht-name"><img src="{{ $yacht->imageUrl }}" alt=""><div><strong>{{ $yacht->name }}</strong><small>/yachts/{{ $yacht->slug }}</small></div></td>
                                <td>{{ $yacht->typeLabel }}</td>
                                <td>{{ $yacht->guest_capacity }}</td>
                                <td>{{ $yacht->formattedWeeklyRate ?? 'Not set' }}</td>
                                <td><span class="admin-badge {{ $yacht->is_published ? 'admin-badge--live' : '' }}">{{ $yacht->is_published ? 'Published' : 'Draft' }}</span></td>
                                <td><a class="admin-text-link" href="{{ route('admin.yachts.edit', $yacht) }}">Edit</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="admin-pagination">{{ $yachts->links() }}</div>
        @else
            <p class="admin-empty">No yacht profiles yet. Add one to get started.</p>
        @endif
    </section>
@endsection
