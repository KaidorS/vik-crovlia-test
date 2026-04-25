<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Date;

class Report extends Model
{
    use SoftDeletes;
    protected $fillable = ['user_id', 'address', 'revenue'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function hasTodayReportForUser(int $userId): bool
    {
        return self::where('user_id', $userId)
            ->whereDate('created_at', Date::today())
            ->exists();
    }
}
