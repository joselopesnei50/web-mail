<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Support\Facades\Crypt;
use Filament\Models\Contracts\FilamentUser;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable;

    public function canAccessFilament(): bool
    {
        return $this->role === 'super_admin' || $this->role === 'admin';
    }

    protected $fillable = [
        'name',
        'email',
        'password',
        'company_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'mailbox_password_encrypted',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'has_mailbox' => 'boolean',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function emails()
    {
        return $this->hasMany(Email::class);
    }

    public function setMailboxPassword(string $plain): void
    {
        $this->mailbox_password_encrypted = Crypt::encryptString($plain);
    }

    public function getMailboxPassword(): ?string
    {
        if (! $this->mailbox_password_encrypted) {
            return null;
        }
        try {
            return Crypt::decryptString($this->mailbox_password_encrypted);
        } catch (\Throwable $e) {
            return null;
        }
    }

    protected static function booted()
    {
        static::addGlobalScope(new \App\Scopes\TenantScope);
    }
}
