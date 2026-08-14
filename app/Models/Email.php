<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sender',
        'recipient',
        'subject',
        'body',
        'is_read',
        'type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function aiReport()
    {
        return $this->hasOne(EmailAiReport::class);
    }

    protected static function booted()
    {
        static::addGlobalScope(new \App\Scopes\TenantScope);

        static::creating(function (Email $email) {
            if ($email->company_id === null && auth()->check()) {
                $email->company_id = auth()->user()->company_id;
            }
        });
    }
}
