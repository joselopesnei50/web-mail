<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'domain',
        'is_active',
        'max_users',
        'max_emails_month',
        'storage_limit_mb',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
