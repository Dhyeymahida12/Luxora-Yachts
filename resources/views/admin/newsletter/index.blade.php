@extends('admin.layout')
@section('title', 'Newsletter subscribers | Luxora Admin')

@section('content')
    <div class="admin-page-heading">
        <div>
            <p class="admin-eyebrow">AUDIENCE</p>
            <h1>Newsletter subscribers</h1>
            <p>{{ number_format($subscriptions->total()) }} email addresses stored in the database.</p>
        </div>
        <a class="admin-button" href="{{ route('admin.newsletter.export') }}">Export CSV</a>
    </div>

    <section class="admin-panel">
        @if ($subscriptions->isNotEmpty())
            <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead><tr><th>Email</th><th>Subscribed</th></tr></thead>
                    <tbody>
                        @foreach ($subscriptions as $subscription)
                            <tr><td>{{ $subscription->email }}</td><td>{{ $subscription->created_at->format('M j, Y') }}</td></tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="admin-pagination">{{ $subscriptions->links() }}</div>
        @else
            <p class="admin-empty">No newsletter subscribers yet.</p>
        @endif
    </section>
@endsection
