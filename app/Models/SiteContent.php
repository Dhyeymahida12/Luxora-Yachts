<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteContent extends Model
{
    protected $fillable = [
        'page_key',
        'content',
    ];

    protected function casts(): array
    {
        return [
            'content' => 'array',
        ];
    }
}
