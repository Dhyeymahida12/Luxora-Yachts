@extends('layouts.app')
@section('title', 'My Account | Luxora Yachts')
@section('body-class', 'dark')

@section('content')
<section class="page account-page">
    <p class="eyebrow">YOUR LUXORA ACCOUNT</p>
    <h1>WELCOME, {{ $user->name }}.</h1>
    <p class="account-page__email">{{ $user->email }}</p>
    <p class="account-page__notice">Your account is stored in this site’s database. Passwords are securely hashed and are never displayed here.</p>

    <div class="account-page__heading">
        <div>
            <p class="eyebrow">YOUR ENQUIRIES</p>
            <h2>Conversations you’ve started.</h2>
        </div>
        <a class="link-arrow" href="{{ route('contact') }}">START AN ENQUIRY <span>&rarr;</span></a>
    </div>

    @if ($enquiries->isNotEmpty())
        <div class="account-enquiries">
            @foreach ($enquiries as $enquiry)
                <article class="account-enquiry">
                    <div class="account-enquiry__heading">
                        <div>
                            <span>{{ $enquiry->created_at->format('M j, Y') }}</span>
                            <h3>{{ $enquiry->service ? ucfirst($enquiry->service).' enquiry' : 'General enquiry' }}</h3>
                        </div>
                        @if ($enquiry->yacht)
                            <span class="account-enquiry__yacht">{{ $enquiry->yacht }}</span>
                        @endif
                    </div>
                    <p>{{ $enquiry->message }}</p>
                    <div class="account-enquiry__details">
                        @if ($enquiry->destination)<span>{{ $enquiry->destination }}</span>@endif
                        @if ($enquiry->charter_start_date && $enquiry->charter_end_date)
                            <span>{{ $enquiry->charter_start_date }} – {{ $enquiry->charter_end_date }}</span>
                        @endif
                        @if ($enquiry->guests)<span>{{ $enquiry->guests }} guests</span>@endif
                        @if ($enquiry->budget)<span>{{ $enquiry->budget }}</span>@endif
                    </div>
                </article>
            @endforeach
        </div>
    @else
        <div class="account-page__empty">
            <h3>No enquiries yet.</h3>
            <p>When you send an enquiry while signed in, it will appear here.</p>
            <a class="link-arrow" href="{{ route('charter') }}">EXPLORE CHARTER YACHTS <span>&rarr;</span></a>
        </div>
    @endif
</section>
@endsection
