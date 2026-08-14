<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class EmailAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'email_id',
        'path',
        'original_name',
        'mime',
        'size',
    ];

    public function email()
    {
        return $this->belongsTo(Email::class);
    }

    public function humanSize(): string
    {
        $bytes = (int) $this->size;
        if ($bytes < 1024) return "{$bytes} B";
        if ($bytes < 1048576) return round($bytes / 1024, 1) . ' KB';
        return round($bytes / 1048576, 1) . ' MB';
    }

    protected static function booted()
    {
        static::deleting(function (EmailAttachment $att) {
            if ($att->path && Storage::disk('local')->exists($att->path)) {
                Storage::disk('local')->delete($att->path);
            }
        });
    }
}
