<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class CompanyMaterial extends Model
{
    use HasFactory, HasUuids;

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'CHAR';

    protected $fillable = [
        'company_id',
        'material_id',
    ];

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    /**
     * Scope a query to only include company materials.
     */
    public function scopeOf(Builder $query, $companyId): void
    {
        $query->where('company_id', $companyId);
    }
}
