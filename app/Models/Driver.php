<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Driver extends Model
{
    use HasFactory, HasUuids;

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'CHAR';

    protected $fillable = [
        'name',
        'contact',
        'company_id',
    ];

    protected $with = ['company'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Scope a query to only include company drivers.
     */
    public function scopeOf(Builder $query, $companyId): void
    {
        $query->where('company_id', $companyId);
    }
}
