<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use SoftDeletes;
    protected $fillable = ['title', 'description', 'content', 'author'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
