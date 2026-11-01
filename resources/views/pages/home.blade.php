@extends('layouts.app')
@section('title', 'Luxora Yachts | Luxury Yacht Charter')

@section('content')
<section class="hero hero--video">
    <video class="hero__video" autoplay muted loop playsinline preload="auto" @if ($siteContent['video_poster_url']) poster="{{ $siteContent['video_poster_url'] }}" @endif aria-hidden="true" tabindex="-1">
        <source src="{{ config('app.home_hero_video_url') ?: asset('videos/home-hero.mp4') }}" type="video/mp4">
    </video>
    <div class="hero__text fade-in">
        <h1>{!! nl2br(e($siteContent['headline'])) !!}</h1>
        <p>{{ $siteContent['description'] }}</p>
        <a class="link-arrow" href="{{ route('charter') }}">CHARTER WITH US <span>&rarr;</span></a>
    </div>
</section>

<section class="home-discover">
    <div class="home-discover__intro">
        <p class="eyebrow">A BETTER WAY TO BEGIN</p>
        <h2>WHERE WILL THE WATER TAKE YOU?</h2>
        <p>Choose the journey you have in mind. We’ll help with the details that make it possible.</p>
    </div>
    <div class="home-discover__grid">
        <a class="home-discover__card" href="{{ route('charter') }}" style="background-image:url('{{ asset('images/yacht-1.jpg') }}')">
            <span>01 / CHARTER</span>
            <div><h3>Find your yacht</h3><p>Compare styles, guest space and indicative weekly rates.</p><span class="home-discover__link">EXPLORE THE COLLECTION <b>&rarr;</b></span></div>
        </a>
        <a class="home-discover__card" href="{{ route('destinations') }}" style="background-image:url('{{ asset('images/summer.jpg') }}')">
            <span>02 / DESTINATIONS</span>
            <div><h3>Choose your coastline</h3><p>Discover the Mediterranean, Caribbean and beyond.</p><span class="home-discover__link">EXPLORE DESTINATIONS <b>&rarr;</b></span></div>
        </a>
        <a class="home-discover__card" href="{{ route('buy') }}" style="background-image:url('{{ asset('images/yacht-5.jpg') }}')">
            <span>03 / OWNERSHIP</span>
            <div><h3>Find a yacht to own</h3><p>Get considered guidance for your next chapter on the water.</p><span class="home-discover__link">EXPLORE BUYING <b>&rarr;</b></span></div>
        </a>
        <a class="home-discover__card" href="{{ route('build') }}" style="background-image:url('{{ asset('images/build-planning.jpg') }}')">
            <span>04 / NEW BUILD</span>
            <div><h3>Make it your own</h3><p>Bring your vision together with the right design and shipyard.</p><span class="home-discover__link">DISCOVER NEW BUILDS <b>&rarr;</b></span></div>
        </a>
    </div>
</section>

<section class="split">
    <img class="split__img blur-reveal" src="{{ asset('images/intro-1.jpg') }}" alt="Guest aboard a yacht">
    <div class="split__text">
        <h3>WHERE POSSIBILITIES ARE ENDLESS, AND EVERY EXPERIENCE IS WORLD-CLASS</h3>
        <p>A luxury yacht charter gives you the freedom to experience the most beautiful and remote places on Earth. From spectacular coastlines and far-flung archipelagos to unmissable events in some of the world's most iconic destinations, discover it all from a place of unparalleled privacy and luxury.</p>
    </div>
</section>

<section class="split split--reverse">
    <div class="split__text">
        <h3>FROM DESTINATIONS TO DINING, EVERY DECISION IS ALL ABOUT YOU</h3>
        <p>A luxury yacht charter is about more than just the destination and the vessel. It's about world-class cuisine, stand-out service, and indulgent amenities. It's where the extraordinary becomes reality, and where lifelong memories are made with those who matter the most.</p>
    </div>
    <img class="split__img" src="{{ asset('images/intro-2.jpg') }}" alt="A catamaran resting offshore in bright blue water">
</section>

<section class="home-editorial" style="background-image:url('{{ asset('images/art-of-leaving.jpg') }}')">
    <div class="home-editorial__content">
        <p class="eyebrow">THE LUXORA APPROACH</p>
        <h2>TAKE THE<br>SCENIC ROUTE.</h2>
        <p>There is no single way to experience the sea. We begin with what matters to you, then bring the yacht, people and details together around it.</p>
        <div class="home-editorial__notes">
            <article><span>01</span><p>A pace that feels like your own</p></article>
            <article><span>02</span><p>Places worth staying a little longer</p></article>
            <article><span>03</span><p>Thoughtful details, handled together</p></article>
        </div>
        <a class="link-arrow" href="{{ route('contact') }}">TELL US WHAT YOU’RE IMAGINING <span>&rarr;</span></a>
    </div>
</section>

<section class="dest">
    <img class="dest__hero" src="{{ asset('images/dest-main.jpg') }}" alt="Luxury motor yacht at sea">
    <div class="dest__list">
        <small>EXPLORE THE WORLD</small>
        <h3>PRIVATE YACHT CHARTER DESTINATIONS</h3>
        <a class="link-arrow link-arrow--dark" href="{{ route('destinations') }}">EXPLORE ALL DESTINATIONS <span>&rarr;</span></a>

        <article class="dest__card">
            <img src="{{ asset('images/dest-med.jpg') }}" alt="The Mediterranean">
            <div><h5><a href="{{ route('destinations') }}">THE MEDITERRANEAN</a></h5>
            <p>Sail the storied Mediterranean, where chic coastlines and timeless culture create the perfect playground for unforgettable days at anchor and glamorous nights ashore.</p></div>
        </article>
        <article class="dest__card">
            <img src="{{ asset('images/dest-carib.jpg') }}" alt="Caribbean and Bahamas">
            <div><h5><a href="{{ route('destinations') }}">CARIBBEAN &amp; BAHAMAS</a></h5>
            <p>Discover turquoise waters, powder-soft beaches, and barefoot luxury. The Caribbean and Bahamas offer vibrant island life and endless opportunities to unwind in paradise.</p></div>
        </article>
    </div>
</section>

<section class="home-plan">
    <div class="home-plan__intro">
        <p class="eyebrow">A GOOD FIRST STEP</p>
        <h2>START WITH WHAT<br>MATTERS TO YOU.</h2>
        <p>You do not need to know every detail. A few simple preferences give our team somewhere thoughtful to begin.</p>
    </div>
    <div class="home-plan__steps">
        <article><span>01</span><div><h3>Picture the experience</h3><p>Think about the people coming, the pace you enjoy and what you would love to do together.</p></div></article>
        <article><span>02</span><div><h3>Choose a direction</h3><p>Share a preferred season or coastline—or ask us to help you compare the possibilities.</p></div></article>
        <article><span>03</span><div><h3>Explore your options</h3><p>We can help connect your brief to yacht styles, destinations and the right next conversation.</p></div></article>
    </div>
    <a class="link-arrow link-arrow--dark" href="{{ route('contact') }}">TELL US WHAT YOU’RE IMAGINING <span>&rarr;</span></a>
</section>

<section class="closing">
    <h3>EVERY YACHT, EVERY DESTINATION, ANY ITINERARY — YOU’LL FIND IT RIGHT HERE</h3>
    <p>~ If a luxury yacht is available for charter, our team will have access to it. Our decades of experience and global connections mean we can create bespoke itineraries for any yacht charter in the world. Get in touch today to start planning your perfect escape.</p>
</section>
@endsection
