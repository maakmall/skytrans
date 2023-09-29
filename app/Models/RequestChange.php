<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class RequestChange extends Model
{
    use HasFactory, HasUuids;

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'CHAR';

    protected $fillable = [
        'user_id',
        'action',
        'table',
        'data',
        'data_id',
        'data_before_id',
        'data_change_id',
        'status',
    ];

    public function scopeOf(Builder $query, $userId): void
    {
        $query->where('user_id', $userId);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
