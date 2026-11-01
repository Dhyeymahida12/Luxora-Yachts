<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Yacht extends Model
{
    protected $fillable = [
        'slug',
        'name',
        'type',
        'image',
        'length_m',
        'guest_capacity',
        'cabins',
        'crew_size',
        'build_year',
        'max_speed_knots',
        'cruising_speed_knots',
        'range_nm',
        'weekly_rate_usd',
        'description',
        'overview',
        'cruising_regions',
        'amenities',
        'is_illustrative',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'length_m' => 'decimal:1',
            'guest_capacity' => 'integer',
            'cabins' => 'integer',
            'crew_size' => 'integer',
            'build_year' => 'integer',
            'max_speed_knots' => 'integer',
            'cruising_speed_knots' => 'integer',
            'range_nm' => 'integer',
            'weekly_rate_usd' => 'integer',
            'cruising_regions' => 'array',
            'amenities' => 'array',
            'is_illustrative' => 'boolean',
            'is_published' => 'boolean',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getFormattedWeeklyRateAttribute(): ?string
    {
        return $this->weekly_rate_usd === null
            ? null
            : '$'.number_format($this->weekly_rate_usd);
    }

    public function getTypeLabelAttribute(): string
    {
        return ucfirst($this->type).' yacht';
    }

    public function getLengthLabelAttribute(): string
    {
        $length = (float) $this->length_m;

        return number_format($length, $length === floor($length) ? 0 : 1).' m';
    }

    public function getImageUrlAttribute(): string
    {
        return str_starts_with($this->image, 'storage/')
            ? Storage::disk(config('admin.upload_disk'))->url(substr($this->image, strlen('storage/')))
            : asset('images/'.$this->image);
    }
}
