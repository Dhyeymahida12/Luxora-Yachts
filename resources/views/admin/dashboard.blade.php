@extends('admin.layout')
@section('title', 'Overview | Luxora Admin')

@section('content')
    <div class="admin-page-heading">
        <div>
            <p class="admin-eyebrow">LUXORA YACHTS / ADMINISTRATION</p>
            <h1>Overview</h1>
            <p>Manage your yacht collection, client enquiries and website content.</p>
        </div>
    </div>

    <section class="admin-stats" aria-label="Website overview">
        <a class="admin-stat" href="{{ route('admin.yachts.index') }}">
            <span>YACHT PROFILES</span><strong>{{ $yachtCount }}</strong><small>{{ $publishedYachtCount }} published</small>
        </a>
        <a class="admin-stat" href="{{ route('admin.enquiries.index') }}">
            <span>NEW ENQUIRIES</span><strong>{{ $newEnquiryCount }}</strong><small>{{ $enquiryCount }} total enquiries</small>
        </a>
        <a class="admin-stat" href="{{ route('admin.newsletter.index') }}">
            <span>SUBSCRIBERS</span><strong>{{ $subscriberCount }}</strong><small>Newsletter list</small>
        </a>
    </section>

    <section class="admin-panel">
        <div class="admin-section-heading">
            <div><p class="admin-eyebrow">CLIENT MESSAGES</p><h2>Recent enquiries</h2></div>
            <a class="admin-button admin-button--quiet" href="{{ route('admin.enquiries.index') }}">View all</a>
        </div>
        @if ($recentEnquiries->isNotEmpty())
            <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead><tr><th>Client</th><th>Service</th><th>Received</th><th>Status</th></tr></thead>
                    <tbody>
                        @foreach ($recentEnquiries as $enquiry)
                            <tr>
                                <td><strong>{{ $enquiry->name }}</strong><small>{{ $enquiry->email }}</small></td>
                                <td>{{ $enquiry->service ?: 'General enquiry' }}</td>
                                <td>{{ $enquiry->created_at->format('M j, Y') }}</td>
                                <td><span class="admin-badge">{{ str_replace('_', ' ', $enquiry->status) }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="admin-empty">New enquiries will appear here.</p>
        @endif
    </section>

    <section class="admin-quick-links">
        <a href="{{ route('admin.yachts.create') }}"><span>01</span><div><h3>Add a yacht profile</h3><p>Create a new profile and choose whether it is visible to visitors.</p></div><b>&rarr;</b></a>
        <a href="{{ route('admin.content.index') }}"><span>02</span><div><h3>Update page content</h3><p>Change hero headlines, descriptions and images for public pages.</p></div><b>&rarr;</b></a>
        <a href="{{ route('admin.newsletter.index') }}"><span>03</span><div><h3>Export subscribers</h3><p>Download the newsletter email list as a CSV.</p></div><b>&rarr;</b></a>
    </section>
@endsection
