@extends('admin.layout')
@section('title', ($yacht->exists ? 'Edit '.$yacht->name : 'Add yacht').' | Luxora Admin')

@section('content')
    <div class="admin-page-heading">
        <div>
            <p class="admin-eyebrow">COLLECTION / YACHT PROFILES</p>
            <h1>{{ $yacht->exists ? 'Edit yacht' : 'Add a yacht' }}</h1>
            <p>Use verified specifications for real listings. Mark sample profiles as illustrative.</p>
        </div>
        <a class="admin-button admin-button--quiet" href="{{ route('admin.yachts.index') }}">Back to yachts</a>
    </div>

    <form class="admin-panel admin-form" method="POST" enctype="multipart/form-data" action="{{ $yacht->exists ? route('admin.yachts.update', $yacht) : route('admin.yachts.store') }}">
        @csrf
        @if ($yacht->exists)
            @method('PUT')
        @endif

        <div class="admin-form-grid">
            <label><span>Profile name</span><input name="name" value="{{ old('name', $yacht->name) }}" required maxlength="255"></label>
            <label><span>URL slug</span><input name="slug" value="{{ old('slug', $yacht->slug) }}" required maxlength="180" pattern="[A-Za-z0-9_-]+"><small>Used in the yacht profile URL.</small></label>
            <label><span>Yacht style</span><select name="type" required><option value="motor" @selected(old('type', $yacht->type) === 'motor')>Motor yacht</option><option value="sailing" @selected(old('type', $yacht->type) === 'sailing')>Sailing yacht</option></select></label>
            <label><span>Length (metres)</span><input type="number" name="length_m" min="1" max="200" step="0.1" value="{{ old('length_m', $yacht->length_m) }}" required></label>
            <label><span>Guest capacity</span><input type="number" name="guest_capacity" min="1" max="30" value="{{ old('guest_capacity', $yacht->guest_capacity) }}" required></label>
            <label><span>Cabins</span><input type="number" name="cabins" min="1" max="30" value="{{ old('cabins', $yacht->cabins) }}" required></label>
            <label><span>Crew size</span><input type="number" name="crew_size" min="1" max="100" value="{{ old('crew_size', $yacht->crew_size) }}"></label>
            <label><span>Build year</span><input type="number" name="build_year" min="1900" max="{{ now()->year + 2 }}" value="{{ old('build_year', $yacht->build_year) }}" required></label>
            <label><span>Maximum speed (knots)</span><input type="number" name="max_speed_knots" min="1" max="100" value="{{ old('max_speed_knots', $yacht->max_speed_knots) }}"></label>
            <label><span>Cruising speed (knots)</span><input type="number" name="cruising_speed_knots" min="1" max="100" value="{{ old('cruising_speed_knots', $yacht->cruising_speed_knots) }}"></label>
            <label><span>Range (nautical miles)</span><input type="number" name="range_nm" min="1" max="100000" value="{{ old('range_nm', $yacht->range_nm) }}"></label>
            <label><span>Example weekly rate (USD)</span><input type="number" name="weekly_rate_usd" min="1" max="1000000000" value="{{ old('weekly_rate_usd', $yacht->weekly_rate_usd) }}"><small>Leave blank if unknown. Sample rates are labelled illustrative on the site.</small></label>
            <label class="admin-form-grid__wide"><span>Short description</span><textarea name="description" rows="3" maxlength="1000" required>{{ old('description', $yacht->description) }}</textarea></label>
            <label class="admin-form-grid__wide"><span>Full overview</span><textarea name="overview" rows="4" maxlength="3000" required>{{ old('overview', $yacht->overview) }}</textarea></label>
            <label><span>Cruising regions <small>(one per line)</small></span><textarea name="cruising_regions" rows="5" required>{{ old('cruising_regions', implode("\n", $yacht->cruising_regions ?? [])) }}</textarea></label>
            <label><span>Amenities <small>(one per line)</small></span><textarea name="amenities" rows="5" required>{{ old('amenities', implode("\n", $yacht->amenities ?? [])) }}</textarea></label>
            <label class="admin-form-grid__wide"><span>Choose an existing photo</span>
                <select name="image">
                    @foreach ($images as $image)
                        <option value="{{ $image }}" @selected(old('image', $yacht->image) === $image)>{{ $image }}</option>
                    @endforeach
                    @if ($yacht->exists && ! in_array($yacht->image, $images, true))
                        <option value="{{ $yacht->image }}" @selected(old('image', $yacht->image) === $yacht->image)>Current uploaded image</option>
                    @endif
                </select>
            </label>
            <label class="admin-form-grid__wide"><span>Or upload a yacht photo</span><input type="file" name="image_file" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"><small>JPEG, PNG or WebP; up to 8 MB, at least 500 × 300 pixels.</small></label>
        </div>

        <div class="admin-checks">
            <label><input type="checkbox" name="is_illustrative" value="1" @checked(old('is_illustrative', $yacht->exists ? $yacht->is_illustrative : true))> Mark this profile as illustrative</label>
            <label><input type="checkbox" name="is_published" value="1" @checked(old('is_published', $yacht->exists ? $yacht->is_published : true))> Publish this profile on the public site</label>
        </div>

        <div class="admin-form-actions">
            <button class="admin-button" type="submit">{{ $yacht->exists ? 'Save changes' : 'Create yacht profile' }}</button>
            @if ($yacht->exists)
                <button class="admin-button admin-button--danger" type="submit" form="delete-yacht">Delete profile</button>
            @endif
        </div>
    </form>
    @if ($yacht->exists)
        <form id="delete-yacht" method="POST" action="{{ route('admin.yachts.destroy', $yacht) }}" onsubmit="return confirm('Delete this yacht profile?')">
            @csrf
            @method('DELETE')
        </form>
    @endif
@endsection
