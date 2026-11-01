<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function contactEnquiries(): HasMany
    {
        return $this->hasMany(ContactEnquiry::class);
    }

    public function isAdmin(): bool
    {
        $adminEmail = config('admin.email');

        return is_string($adminEmail)
            && $adminEmail !== ''
            && mb_strtolower($this->email) === mb_strtolower($adminEmail);
    }
}
