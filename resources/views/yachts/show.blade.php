@extends('layouts.app')
@section('title', $yacht->name.' | Yacht Profile | Luxora Yachts')
@section('body-class', 'dark')

@section('content')
<section class="hero hero--short yacht-detail-hero" style="background-image:url('{{ asset('images/'.$yacht->image) }}')">
    <div class="hero__text fade-in">
        <p class="eyebrow">{{ $yacht->typeLabel }} <span>&middot;</span> Illustrative profile</p>
        <h1>{{ $yacht->name }}</h1>
        <p>{{ $yacht->description }}</p>
        <a class="link-arrow" href="{{ route('contact', ['service' => 'charter', 'yacht' => $yacht->name]) }}">ASK ABOUT THIS PROFILE <span>&rarr;</span></a>
    </div>
</section>

<section class="yacht-detail">
    <div class="yacht-detail__intro">
        <p class="eyebrow">A CLOSER LOOK</p>
        <h2>A SAMPLE PROFILE TO HELP YOU COMPARE.</h2>
        <p>{{ $yacht->overview }}</p>
        <p class="yacht-detail__disclaimer">This yacht name, image pairing, year, specifications, amenities and rate are illustrative examples. They do not represent a verified vessel or current availability. Ask our team to confirm real yacht details and pricing.</p>
    </div>

    <div class="yacht-detail__spec-grid" aria-label="Illustrative yacht specifications">
        <div><span>LENGTH</span><strong>{{ $yacht->lengthLabel }}</strong></div>
        <div><span>GUEST CAPACITY</span><strong>{{ $yacht->guest_capacity }} guests</strong></div>
        <div><span>GUEST CABINS</span><strong>{{ $yacht->cabins }}</strong></div>
        <div><span>CREW PROFILE</span><strong>{{ $yacht->crew_size ? $yacht->crew_size.' crew' : 'Ask our team' }}</strong></div>
        <div><span>EXAMPLE BUILD YEAR</span><strong>{{ $yacht->build_year }}</strong></div>
        <div><span>EXAMPLE WEEKLY RATE</span><strong>{{ $yacht->formattedWeeklyRate ?? 'Ask our team' }}</strong></div>
        <div><span>CRUISING SPEED</span><strong>{{ $yacht->cruising_speed_knots ? $yacht->cruising_speed_knots.' knots' : 'Ask our team' }}</strong></div>
        <div><span>EXAMPLE RANGE</span><strong>{{ $yacht->range_nm ? number_format($yacht->range_nm).' nautical miles' : 'Ask our team' }}</strong></div>
    </div>

    <div class="yacht-detail__lower">
        <section>
            <p class="eyebrow">ON BOARD</p>
            <h2>Spaces and features to consider.</h2>
            <ul class="yacht-detail__amenities">
                @foreach ($yacht->amenities as $amenity)
                    <li>{{ $amenity }}</li>
                @endforeach
            </ul>
        </section>
        <section>
            <p class="eyebrow">POSSIBLE CRUISING AREAS</p>
            <h2>Start with the places you love.</h2>
            <p class="yacht-detail__disclaimer">Regions below are examples for discussion only; actual itineraries depend on vessel capability, season, regulations and confirmed availability.</p>
            <ul class="yacht-detail__regions">
                @foreach ($yacht->cruising_regions as $region)
                    <li>{{ $region }}</li>
                @endforeach
            </ul>
        </section>
    </div>

    <section class="yacht-detail__questions">
        <p class="eyebrow">WHEN YOU COMPARE REAL YACHTS</p>
        <h2>DETAILS WORTH CONFIRMING.</h2>
        <div>
            <article><h3>Availability and itinerary</h3><p>Confirm the dates, permitted cruising areas and whether your preferred route is practical for the yacht.</p></article>
            <article><h3>What the rate covers</h3><p>Ask for a written breakdown of charter fees, additional expenses, taxes, inclusions and payment terms.</p></article>
            <article><h3>Current specifications</h3><p>Verify the vessel, guest capacity, equipment and crew arrangements directly before making a decision.</p></article>
        </div>
    </section>

    <div class="yacht-detail__actions">
        <a class="link-arrow link-arrow--dark" href="{{ route('contact', ['service' => 'charter', 'yacht' => $yacht->name]) }}">ENQUIRE ABOUT {{ strtoupper($yacht->name) }} <span>&rarr;</span></a>
        <a class="link-arrow link-arrow--dark" href="{{ route('yachts.index') }}">BACK TO ALL YACHTS <span>&rarr;</span></a>
    </div>
</section>
@endsection
