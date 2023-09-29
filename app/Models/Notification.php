<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class Notification extends Model
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
        'title',
        'description',
        'icon',
        'color',
        'link',
        'is_read',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('user', function (Builder $builder) {
            $builder->where('user_id', Auth::user()->id);
        });
    }

    /**
     * Scope a query to only include notif is_read false.
     */
    public function scopeNotRead(Builder $query): void
    {
        $query->where('is_read', false);
    }
}
