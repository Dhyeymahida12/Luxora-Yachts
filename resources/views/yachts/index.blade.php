@extends('layouts.app')
@section('title', 'Yacht Profiles | Luxora Yachts')
@section('body-class', 'dark')

@section('content')
<section class="hero hero--short yacht-index-hero" style="background-image:url('{{ asset('images/buy-planning.jpg') }}')">
    <div class="hero__text fade-in">
        <p class="eyebrow">EXPLORE THE COLLECTION</p>
        <h1>YACHTS,<br>IN DETAIL.</h1>
        <p>Compare yacht styles, guest capacity, onboard features and sample weekly rates. Find a starting point for your conversation.</p>
        <a class="link-arrow" href="#yacht-directory">BROWSE PROFILES <span>&darr;</span></a>
    </div>
</section>

<section class="yacht-directory" id="yacht-directory">
    <header class="yacht-directory__intro">
        <p class="eyebrow">THE LUXORA COLLECTION</p>
        <h2>FIND THE RIGHT FIT FOR YOUR TIME AT SEA.</h2>
        <p>These profiles are illustrative examples for comparison—not verified listings, live availability, or guaranteed pricing. Ask our team about current yachts and confirmed specifications.</p>
    </header>

    <form class="yacht-directory__filters" method="GET" action="{{ route('yachts.index') }}">
        <label>
            <span>SEARCH</span>
            <input type="search" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Name or yacht details">
        </label>
        <label>
            <span>YACHT STYLE</span>
            <select name="type">
                <option value="">All styles</option>
                <option value="motor" @selected(($filters['type'] ?? '') === 'motor')>Motor yacht</option>
                <option value="sailing" @selected(($filters['type'] ?? '') === 'sailing')>Sailing yacht</option>
            </select>
        </label>
        <label>
            <span>GUESTS</span>
            <select name="guests">
                <option value="">Any party size</option>
                @foreach ([4, 6, 8, 10, 12] as $guestCount)
                    <option value="{{ $guestCount }}" @selected((string) ($filters['guests'] ?? '') === (string) $guestCount)>{{ $guestCount }} or more</option>
                @endforeach
            </select>
        </label>
        <label>
            <span>WEEKLY STARTING RATE</span>
            <select name="budget">
                <option value="">Any rate</option>
                @foreach ([75000, 100000, 150000, 250000] as $budget)
                    <option value="{{ $budget }}" @selected((string) ($filters['budget'] ?? '') === (string) $budget)>Up to ${{ number_format($budget) }}</option>
                @endforeach
            </select>
        </label>
        <button type="submit">APPLY FILTERS</button>
        @if ($filters !== [])
            <a class="yacht-directory__clear" href="{{ route('yachts.index') }}">CLEAR</a>
        @endif
    </form>

    <p class="yacht-directory__count">{{ $yachts->total() }} yacht {{ $yachts->total() === 1 ? 'profile' : 'profiles' }}</p>

    @if ($yachts->isNotEmpty())
        <div class="yacht-directory__grid">
            @foreach ($yachts as $yacht)
                <article class="yacht">
                    <a class="yacht__image" href="{{ route('yachts.show', $yacht) }}" aria-label="View {{ $yacht->name }} yacht details">
                        <img src="{{ asset('images/'.$yacht->image) }}" alt="{{ $yacht->typeLabel }} profile for {{ $yacht->name }}">
                        <span class="yacht__type">{{ $yacht->typeLabel }}</span>
                    </a>
                    <div class="yacht__body">
                        <div class="yacht__heading">
                            <div>
                                <h3>{{ $yacht->name }}</h3>
                                <p>{{ $yacht->lengthLabel }} <span>&middot;</span> Example year {{ $yacht->build_year }}</p>
                            </div>
                            <p class="yacht__rate"><small>EXAMPLE RATE</small><strong>{{ $yacht->formattedWeeklyRate ?? 'ASK OUR TEAM' }}</strong><small>PER WEEK</small></p>
                        </div>
                        <p class="yacht__description">{{ $yacht->description }}</p>
                        <div class="yacht__specs">
                            <span>{{ $yacht->guest_capacity }} guests</span>
                            <span>{{ $yacht->cabins }} cabins</span>
                        </div>
                        <a class="yacht__link" href="{{ route('yachts.show', $yacht) }}">VIEW FULL PROFILE <span>&rarr;</span></a>
                    </div>
                </article>
            @endforeach
        </div>
        <nav class="yacht-directory__pagination" aria-label="Yacht profile pages">
            {{ $yachts->links() }}
        </nav>
    @else
        <div class="yacht-directory__empty">
            <h3>No profiles match those filters.</h3>
            <p>Try a different yacht style, guest count or rate.</p>
            <a class="link-arrow link-arrow--dark" href="{{ route('yachts.index') }}">VIEW ALL PROFILES <span>&rarr;</span></a>
        </div>
    @endif

    <aside class="yacht-directory__guide">
        <p class="eyebrow">HOW TO COMPARE</p>
        <h2>LOOK BEYOND THE HEADLINE NUMBER.</h2>
        <div>
            <article><h3>How you will use the yacht</h3><p>Think about the route, time aboard, preferred pace and whether sailing or motor cruising suits your plans.</p></article>
            <article><h3>Space for your group</h3><p>Compare guest capacity, cabin layouts, crew scale and the shared spaces that matter to your party.</p></article>
            <article><h3>The complete budget</h3><p>Sample rates are for illustration. Confirm current pricing, inclusions, expenses, taxes and terms for any real yacht.</p></article>
        </div>
    </aside>
</section>
@endsection
