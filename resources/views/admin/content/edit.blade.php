@extends('admin.layout')
@section('title', 'Edit '.$label.' content | Luxora Admin')

@section('content')
    <div class="admin-page-heading">
        <div>
            <p class="admin-eyebrow">SITE EDITOR / {{ strtoupper($pageKey) }}</p>
            <h1>Edit {{ $label }}</h1>
            <p>Update the hero section shown on the public {{ $label }} page.</p>
        </div>
        <a class="admin-button admin-button--quiet" href="{{ route('admin.content.index') }}">All pages</a>
    </div>

    <form class="admin-panel admin-form" method="POST" enctype="multipart/form-data" action="{{ route('admin.content.update', $pageKey) }}">
        @csrf
        @method('PUT')

        <div class="admin-form-grid">
            @if (array_key_exists('eyebrow', $content))
                <label class="admin-form-grid__wide"><span>Eyebrow</span><input name="eyebrow" value="{{ old('eyebrow', $content['eyebrow']) }}" maxlength="100" required></label>
            @endif
            <label class="admin-form-grid__wide"><span>Headline <small>Use a new line for a deliberate line break.</small></span><textarea name="headline" rows="3" maxlength="240" required>{{ old('headline', $content['headline']) }}</textarea></label>
            <label class="admin-form-grid__wide"><span>Description</span><textarea name="description" rows="4" maxlength="2000" required>{{ old('description', $content['description']) }}</textarea></label>
            @if (array_key_exists('story_title', $content))
                <label class="admin-form-grid__wide"><span>Story section heading</span><input name="story_title" value="{{ old('story_title', $content['story_title']) }}" maxlength="180" required></label>
                <label class="admin-form-grid__wide"><span>Story section text</span><textarea name="story_description" rows="5" maxlength="2000" required>{{ old('story_description', $content['story_description']) }}</textarea></label>
            @endif
            <label class="admin-form-grid__wide"><span>Choose an existing image</span>
                <select name="image">
                    @foreach ($images as $image)
                        <option value="{{ $image }}" @selected(old('image', $content['image']) === $image)>{{ $image }}</option>
                    @endforeach
                    @if (! in_array($content['image'], $images, true))
                        <option value="{{ $content['image'] }}" @selected(old('image', $content['image']) === $content['image'])>Current uploaded image</option>
                    @endif
                </select>
                <small>Used as this page’s hero background. On the homepage it is the video poster.</small>
            </label>
            <label class="admin-form-grid__wide"><span>Or upload a replacement image</span><input type="file" name="image_file" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"><small>JPEG, PNG or WebP; up to 8 MB, at least 500 × 300 pixels.</small></label>
        </div>

        <div class="admin-form-actions">
            <button class="admin-button" type="submit">Save page content</button>
            <a class="admin-text-link" href="{{ $pageKey === 'home' ? route('home') : route($pageKey) }}" target="_blank" rel="noopener">Preview public page ↗</a>
        </div>
    </form>
@endsection
