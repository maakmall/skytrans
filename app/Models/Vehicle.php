<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Vehicle extends Model
{
    use HasFactory, HasUuids;

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'CHAR';

    protected $fillable = [
        'max_capacity',
        'type',
        'plat_number',
        'stnk',
        'company_id'
    ];

    protected $with = ['company'];

    /**
     * Scope a query to only include company vehicle.
     */
    public function scopeOf(Builder $query, $companyId): void
    {
        $query->where('company_id', $companyId);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
