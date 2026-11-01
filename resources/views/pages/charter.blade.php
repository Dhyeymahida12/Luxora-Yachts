@extends('layouts.app')
@section('title', 'Luxury Yacht Charter | Luxora Yachts')
@section('body-class', 'dark')

@section('content')
<section class="hero hero--short charter-hero" style="background-image:url('{{ $siteContent['image_url'] }}')">
    <div class="hero__text fade-in">
        <p class="eyebrow">{{ $siteContent['eyebrow'] }}</p>
        <h1>{!! nl2br(e($siteContent['headline'])) !!}</h1>
        <p>{{ $siteContent['description'] }}</p>
        <a class="link-arrow" href="{{ route('contact', ['service' => 'charter']) }}">START PLANNING <span>&rarr;</span></a>
    </div>
    <a class="charter-hero__scroll" href="#charter-destinations">FIND YOUR INSPIRATION <span>&darr;</span></a>
</section>

<section class="charter-intro">
    <div class="charter-intro__heading">
        <p class="eyebrow">A JOURNEY SHAPED AROUND YOU</p>
        <h2>FIRST, IMAGINE<br>WHERE YOU’LL GO.</h2>
    </div>
    <div class="charter-intro__copy">
        <p>A charter is more than a yacht booking. It’s a chance to set your own pace, spend time in the places you love, and have the details brought together around you.</p>
        <p>Tell us when you’d like to travel, who is coming and what you want the days to feel like. We’ll help shape the next steps with you.</p>
        <div class="charter-intro__links">
            <a class="link-arrow link-arrow--dark" href="{{ route('contact', ['service' => 'charter']) }}">TALK TO A CHARTER SPECIALIST <span>&rarr;</span></a>
            <a class="charter-intro__profiles" href="{{ route('yachts.index') }}">OR COMPARE YACHT PROFILES <span>&rarr;</span></a>
        </div>
    </div>
</section>

<section class="charter-destinations" id="charter-destinations">
    <header class="charter-destinations__intro">
        <p class="eyebrow">A FEW PLACES TO BEGIN</p>
        <h2>WHICH WAY IS THE WATER CALLING?</h2>
        <p>From storied Mediterranean coastlines to island days in the Caribbean, choose a feeling—not a fixed itinerary.</p>
    </header>
    <div class="charter-destinations__grid">
        <article class="charter-destination" style="background-image:url('{{ asset('images/dest-med.jpg') }}')">
            <div class="charter-destination__content">
                <p class="eyebrow">CULTURE · COASTLINES · LONG LUNCHES</p>
                <h3>THE MEDITERRANEAN</h3>
                <p>Move between celebrated harbours and quieter anchorages, with time for a swim, a long lunch and an evening ashore.</p>
                <a href="{{ route('destinations') }}">EXPLORE THE REGION <span>&rarr;</span></a>
            </div>
        </article>
        <article class="charter-destination" style="background-image:url('{{ asset('images/dest-carib.jpg') }}')">
            <div class="charter-destination__content">
                <p class="eyebrow">CLEAR WATER · ISLAND HOPS · EASY DAYS</p>
                <h3>THE CARIBBEAN</h3>
                <p>Find a slower rhythm among bright-water bays, welcoming islands and beaches made for an unhurried afternoon.</p>
                <a href="{{ route('destinations') }}">EXPLORE THE REGION <span>&rarr;</span></a>
            </div>
        </article>
    </div>
</section>

<section class="charter-brief">
    <div class="charter-brief__intro">
        <p class="eyebrow">A USEFUL PLACE TO START</p>
        <h2>THE DETAILS THAT MAKE IT YOURS.</h2>
        <p>You don’t need a finished plan. A few first thoughts help our team make the conversation practical.</p>
    </div>
    <div class="charter-brief__grid">
        <article><span>01 / WHEN</span><h3>Your dates</h3><p>Share your preferred travel window—or tell us if you can be flexible.</p></article>
        <article><span>02 / WHO</span><h3>Your guests</h3><p>Let us know your group size and anything that matters for time aboard.</p></article>
        <article><span>03 / WHERE</span><h3>Your kind of place</h3><p>Name a coastline you love, or the sort of scenery you’d like to wake up to.</p></article>
        <article><span>04 / HOW</span><h3>Your pace</h3><p>Think easy days at anchor, active exploring, time ashore—or a little of everything.</p></article>
    </div>
    <a class="link-arrow link-arrow--dark" href="{{ route('contact', ['service' => 'charter']) }}">SHARE YOUR FIRST IDEAS <span>&rarr;</span></a>
</section>

<section class="charter-guide">
    <div class="charter-guide__intro">
        <p class="eyebrow">THOUGHTFULLY PLANNED. ENTIRELY YOURS.</p>
        <h2>MORE THAN A YACHT.<br>A WORLD OF YOUR OWN.</h2>
        <p>Tell us what you love: quiet coves, a table by the water, a week of discovery with the family. We’ll help bring the right yacht, crew and itinerary together.</p>
        <a class="link-arrow link-arrow--dark" href="{{ route('contact') }}">LET’S PLAN YOUR CHARTER <span>&rarr;</span></a>
    </div>
    <div class="charter-guide__details">
        <article>
            <span>01</span>
            <div><h3>The right match</h3><p>We’ll help you compare yacht styles, guest spaces and onboard amenities against the way you actually like to travel.</p></div>
        </article>
        <article>
            <span>02</span>
            <div><h3>Your own itinerary</h3><p>Set a slower pace among Mediterranean harbours or follow the sunshine through the Caribbean and Bahamas.</p></div>
        </article>
        <article>
            <span>03</span>
            <div><h3>Clearer planning</h3><p>Your charter specialist will walk you through dates, availability and the costs to confirm before you book.</p></div>
        </article>
    </div>
</section>

<section class="banner banner--summer" style="background-image:url('{{ asset('images/summer.jpg') }}')">
    <div class="banner__text">
        <p class="eyebrow">A SEASON WORTH SLOWING DOWN FOR</p>
        <h2>SUMMER IN THE<br>MEDITERRANEAN</h2>
        <p>From Amalfi’s sunlit villages to quiet Sicilian anchorages, find your own rhythm along the coast.</p>
        <a class="link-arrow" href="{{ route('destinations') }}">EXPLORE THE DESTINATIONS <span>&rarr;</span></a>
    </div>
</section>

<section class="charter-faq">
    <div class="charter-faq__intro">
        <p class="eyebrow">A LITTLE MORE CLARITY</p>
        <h2>BEFORE YOU<br>SET SAIL.</h2>
        <p>Good planning starts with the essentials. Share what you know; your charter specialist can help you work through the rest.</p>
    </div>
    <div class="charter-faq__items">
        <details>
            <summary>What information should I have before enquiring?</summary>
            <p>Your preferred dates, guest count, destinations and approximate budget are helpful. If any of those are flexible, say so—there is no need to have a finished itinerary.</p>
        </details>
        <details>
            <summary>What does a sample weekly rate include?</summary>
            <p>Rates on illustrative yacht profiles are examples only. Confirm the yacht’s current rate, what is included, additional expenses, taxes and payment terms in a written proposal.</p>
        </details>
        <details>
            <summary>Can you help if I am not sure which destination to choose?</summary>
            <p>Yes. Tell us when you hope to travel and the kind of experience you have in mind; season, weather, local events and yacht capabilities help shape suitable options.</p>
        </details>
        <details>
            <summary>Are the yachts in the profile directory available to charter?</summary>
            <p>The directory is for comparison and inspiration, not a live inventory. Availability, specifications and commercial terms must be confirmed with our team.</p>
        </details>
    </div>
</section>

<section class="charter-cta">
    <p class="eyebrow">THE BEST JOURNEYS BEGIN WITH A CONVERSATION</p>
    <h2>YOUR NEXT CHAPTER<br>STARTS AT SEA.</h2>
    <a class="link-arrow" href="{{ route('contact') }}">TALK TO A CHARTER SPECIALIST <span>&rarr;</span></a>
</section>
@endsection
