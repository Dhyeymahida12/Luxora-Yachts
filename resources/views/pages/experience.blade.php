@extends('layouts.app')
@section('title', $page['eyebrow'].' | Luxora Yachts')
@section('body-class', 'dark')

@section('content')
<section class="hero hero--short experience-hero" style="background-image:url('{{ $page['image_url'] }}')">
    <div class="hero__text fade-in">
        <p class="eyebrow">{{ $page['eyebrow'] }}</p>
        <h1>{!! nl2br(e($page['headline'])) !!}</h1>
        <p>{{ $page['description'] }}</p>
        <a class="link-arrow" href="{{ route('contact', ['service' => $page['service'] ?? null]) }}">START A CONVERSATION <span>&rarr;</span></a>
    </div>
</section>

<section class="experience-story">
    <img src="{{ asset('images/'.$page['story_image']) }}" alt="{{ $page['story_label'] ?? $page['eyebrow'] }} experience">
    <div>
        <small>{{ $page['story_label'] ?? 'THE LUXORA APPROACH' }}</small>
        <h2>{{ $page['story_title'] }}</h2>
        <p>{{ $page['story_description'] }}</p>
        <a class="link-arrow" href="{{ route('contact', ['service' => $page['service'] ?? null]) }}">TALK TO OUR TEAM <span>&rarr;</span></a>
    </div>
</section>

@if (isset($page['steps']))
    <section class="experience-process">
        <div class="experience-process__intro">
            <p class="eyebrow">HOW WE MAKE PROGRESS</p>
            <h2>{{ $page['process_title'] }}</h2>
        </div>
        <div class="experience-process__grid">
            @foreach ($page['steps'] as $step)
                <article class="experience-process__step">
                    <span>{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                    <h3>{{ $step['title'] }}</h3>
                    <p>{{ $step['body'] }}</p>
                </article>
            @endforeach
        </div>
    </section>

    <section class="experience-brief">
        <div class="experience-brief__image" style="background-image:url('{{ asset('images/'.$page['brief_image']) }}')"></div>
        <div class="experience-brief__content">
            <p class="eyebrow">A USEFUL PLACE TO START</p>
            <h2>{{ $page['brief_title'] }}</h2>
            <p class="experience-brief__intro">{{ $page['brief_intro'] }}</p>
            <ul>
                @foreach ($page['brief_items'] as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ul>
            <a class="link-arrow link-arrow--dark" href="{{ route('contact', ['service' => $page['service']]) }}">BUILD YOUR BRIEF WITH US <span>&rarr;</span></a>
            @if (($page['service'] ?? null) === 'buy')
                <a class="link-arrow link-arrow--dark" href="{{ route('yachts.index') }}">EXPLORE SAMPLE YACHT PROFILES <span>&rarr;</span></a>
            @endif
        </div>
    </section>

    @if (isset($page['planning_items']))
        <section class="experience-planning">
            <figure class="experience-planning__image">
                <img src="{{ asset('images/'.$page['planning_image']) }}" alt="{{ $page['planning_image_alt'] }}">
            </figure>
            <div class="experience-planning__content">
                <p class="eyebrow">BEYOND THE FIRST IMPRESSION</p>
                <h2>{{ $page['planning_title'] }}</h2>
                <p class="experience-planning__intro">{{ $page['planning_intro'] }}</p>
                <div class="experience-planning__items">
                    @foreach ($page['planning_items'] as $item)
                        <article>
                            <span>{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                            <div><h3>{{ $item['title'] }}</h3><p>{{ $item['body'] }}</p></div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endif

<section class="experience-highlights">
    <div class="experience-highlights__intro">
        <small>{{ isset($page['steps']) ? 'WHERE WE CAN HELP' : 'DISCOVER LUXORA' }}</small>
        <h2>{{ isset($page['steps']) ? 'THE DETAILS THAT MOVE YOUR PROJECT FORWARD' : 'MADE FOR THE WAY YOU WANT TO EXPERIENCE THE WATER' }}</h2>
    </div>
    <div class="experience-grid">
        @foreach ($page['highlights'] as $highlight)
            <article class="experience-card">
                <img src="{{ asset('images/'.$highlight['image']) }}" alt="{{ $highlight['title'] }}">
                <div>
                    <h3>{{ $highlight['title'] }}</h3>
                    <p>{{ $highlight['body'] }}</p>
                </div>
            </article>
        @endforeach
    </div>
</section>

<section class="experience-faq">
    <div class="experience-faq__intro">
        <p class="eyebrow">A FEW USEFUL ANSWERS</p>
        <h2>GOOD QUESTIONS<br>TO START WITH.</h2>
        <p>Every brief is different. These practical notes can help you decide what to bring to the first conversation.</p>
    </div>
    <div class="experience-faq__items">
        @foreach ($faqs as $faq)
            <details>
                <summary>{{ $faq['question'] }}</summary>
                <p>{{ $faq['answer'] }}</p>
            </details>
        @endforeach
    </div>
</section>

<section class="experience-cta">
    <small>YOUR NEXT CHAPTER STARTS HERE</small>
    <h2>{{ isset($page['steps']) ? 'START WITH A CLEAR BRIEF.' : 'LET’S MAKE IT EXTRAORDINARY.' }}</h2>
    <a class="link-arrow" href="{{ route('contact', ['service' => $page['service'] ?? null]) }}">GET IN TOUCH <span>&rarr;</span></a>
</section>
@endsection
