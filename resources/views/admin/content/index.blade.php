@extends('admin.layout')
@section('title', 'Page content | Luxora Admin')

@section('content')
    <div class="admin-page-heading">
        <div>
            <p class="admin-eyebrow">SITE EDITOR</p>
            <h1>Page content</h1>
            <p>Edit hero headlines, descriptions and images. Changes are saved to the database and appear on the public site.</p>
        </div>
    </div>

    <section class="admin-page-list">
        @foreach ($pages as $key => $page)
            <a class="admin-page-card" href="{{ route('admin.content.edit', $key) }}">
                <div><p class="admin-eyebrow">{{ strtoupper($key) }}</p><h2>{{ $page['label'] }}</h2><p>{{ \Illuminate\Support\Str::limit($page['content']['description'], 125) }}</p></div>
                <b>&rarr;</b>
            </a>
        @endforeach
    </section>
@endsection
