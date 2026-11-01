<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactEnquiry extends Model
{
    protected $fillable = [
        'name',
        'email',
        'message',
        'user_id',
        'service',
        'yacht',
        'destination',
        'charter_start_date',
        'charter_end_date',
        'guests',
        'budget',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'charter_start_date' => 'date',
            'charter_end_date' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
