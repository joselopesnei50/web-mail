<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailAiReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'email_id',
        'sentiment',
        'urgency',
        'summary',
        'suggested_reply',
    ];

    public function email()
    {
        return $this->belongsTo(Email::class);
    }
}
