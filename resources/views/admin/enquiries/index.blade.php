@extends('admin.layout')
@section('title', 'Enquiries | Luxora Admin')

@section('content')
    <div class="admin-page-heading">
        <div>
            <p class="admin-eyebrow">CLIENT MESSAGES</p>
            <h1>Enquiries</h1>
            <p>Review submitted requests and keep each conversation’s status up to date.</p>
        </div>
    </div>

    @forelse ($enquiries as $enquiry)
        <article class="admin-panel admin-enquiry">
            <header>
                <div>
                    <p class="admin-eyebrow">{{ $enquiry->service ?: 'GENERAL ENQUIRY' }} · {{ $enquiry->created_at->format('M j, Y · g:i A') }}</p>
                    <h2>{{ $enquiry->name }}</h2>
                    <a href="mailto:{{ $enquiry->email }}">{{ $enquiry->email }}</a>
                </div>
                <form class="admin-status-form" method="POST" action="{{ route('admin.enquiries.update', $enquiry) }}">
                    @csrf
                    @method('PATCH')
                    <label><span>Status</span>
                        <select name="status">
                            @foreach ($statuses as $status)
                                <option value="{{ $status }}" @selected(old('status', $enquiry->status) === $status)>{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                    </label>
                    <button class="admin-button admin-button--small" type="submit">Update</button>
                </form>
            </header>
            <div class="admin-enquiry__details">
                @if ($enquiry->yacht)<span>Yacht: {{ $enquiry->yacht }}</span>@endif
                @if ($enquiry->destination)<span>Destination: {{ $enquiry->destination }}</span>@endif
                @if ($enquiry->guests)<span>Guests: {{ $enquiry->guests }}</span>@endif
                @if ($enquiry->budget)<span>Budget: {{ $enquiry->budget }}</span>@endif
                @if ($enquiry->charter_start_date)<span>Dates: {{ $enquiry->charter_start_date->format('M j, Y') }}@if ($enquiry->charter_end_date) – {{ $enquiry->charter_end_date->format('M j, Y') }}@endif</span>@endif
            </div>
            <p class="admin-enquiry__message">{!! nl2br(e($enquiry->message)) !!}</p>
        </article>
    @empty
        <section class="admin-panel admin-empty">No client enquiries have been received yet.</section>
    @endforelse

    <div class="admin-pagination">{{ $enquiries->links() }}</div>
@endsection
