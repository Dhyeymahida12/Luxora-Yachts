@extends('layouts.app')
@section('title', 'Contact | Luxora Yachts')
@section('body-class', 'dark')

@section('content')
<section class="page contact-page">
    <p class="eyebrow">A THOUGHTFUL FIRST STEP</p>
    <h1>LET’S TALK ABOUT YOUR YACHT PLANS.</h1>
    <p class="contact-page__intro">Tell us what you are considering—chartering, buying, building or redesigning a yacht—and we’ll direct your enquiry to the right team.</p>
    @if (session('sent')) <p class="notice" role="status">{{ session('sent') }}</p> @endif
    <form method="POST" action="{{ route('contact.send') }}" class="form contact-form">
        @csrf
        <fieldset class="contact-form__trip">
            <legend>WHAT ARE YOU PLANNING? <span>OPTIONAL</span></legend>
            <label for="service">HOW CAN WE HELP?</label>
            <select id="service" name="service">
                <option value="">Choose a service</option>
                @foreach ($services as $serviceValue => $serviceLabel)
                    <option value="{{ $serviceValue }}" @selected(old('service', $selectedService) === $serviceValue)>{{ $serviceLabel }}</option>
                @endforeach
            </select>
            @error('service')<em>{{ $message }}</em>@enderror

            <p class="contact-form__note">If your enquiry is about charter, these optional trip details can help us understand what you have in mind.</p>
            <label for="yacht">YACHT OF INTEREST</label>
            <select id="yacht" name="yacht">
                <option value="">Open to recommendations</option>
                @foreach ($yachts as $yacht)
                    <option value="{{ $yacht }}" @selected(old('yacht', $selectedYacht) === $yacht)>{{ $yacht }}</option>
                @endforeach
            </select>
            @error('yacht')<em>{{ $message }}</em>@enderror

            <label for="destination">DESTINATION</label>
            <select id="destination" name="destination">
                <option value="">Not decided yet</option>
                @foreach ($destinations as $destination)
                    <option value="{{ $destination }}" @selected(old('destination') === $destination)>{{ $destination }}</option>
                @endforeach
            </select>
            @error('destination')<em>{{ $message }}</em>@enderror

            <div class="contact-form__dates">
                <div>
                    <label for="charter-start-date">PREFERRED START</label>
                    <input id="charter-start-date" name="charter_start_date" type="date" value="{{ old('charter_start_date') }}">
                    @error('charter_start_date')<em>{{ $message }}</em>@enderror
                </div>
                <div>
                    <label for="charter-end-date">PREFERRED END</label>
                    <input id="charter-end-date" name="charter_end_date" type="date" value="{{ old('charter_end_date') }}">
                    @error('charter_end_date')<em>{{ $message }}</em>@enderror
                </div>
            </div>

            <div class="contact-form__dates">
                <div>
                    <label for="guests">GUESTS</label>
                    <select id="guests" name="guests">
                        <option value="">Not sure yet</option>
                        @for ($guestCount = 1; $guestCount <= 12; $guestCount++)
                            <option value="{{ $guestCount }}" @selected((string) old('guests') === (string) $guestCount)>{{ $guestCount }} {{ $guestCount === 1 ? 'guest' : 'guests' }}</option>
                        @endfor
                    </select>
                    @error('guests')<em>{{ $message }}</em>@enderror
                </div>
                <div>
                    <label for="budget">WEEKLY STARTING BUDGET</label>
                    <select id="budget" name="budget">
                        <option value="">Prefer to discuss</option>
                        @foreach ($budgets as $budget)
                            <option value="{{ $budget }}" @selected(old('budget') === $budget)>{{ $budget }}</option>
                        @endforeach
                    </select>
                    @error('budget')<em>{{ $message }}</em>@enderror
                </div>
            </div>
        </fieldset>

        <fieldset class="contact-form__details">
            <legend>HOW CAN WE REACH YOU?</legend>
            <label for="name">YOUR NAME</label>
            <input id="name" name="name" autocomplete="name" maxlength="100" value="{{ old('name') }}" required>
            @error('name')<em>{{ $message }}</em>@enderror

            <label for="email">EMAIL ADDRESS</label>
            <input id="email" name="email" type="email" autocomplete="email" maxlength="255" value="{{ old('email') }}" required>
            @error('email')<em>{{ $message }}</em>@enderror

            <label for="message">ANYTHING ELSE WE SHOULD KNOW?</label>
            <textarea id="message" name="message" rows="5" maxlength="2000" placeholder="Tell us what you are considering and what would be helpful next." required>{{ old('message') }}</textarea>
            @error('message')<em>{{ $message }}</em>@enderror
            <button type="submit">SEND MY ENQUIRY <span>&rarr;</span></button>
        </fieldset>
    </form>
</section>
@endsection
