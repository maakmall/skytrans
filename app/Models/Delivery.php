<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Delivery extends Model
{
    use HasFactory;

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    // protected $with = ['material', 'company'];

    protected $fillable = [
        'no',
        'company_id',
        'company_name',
        'material_code',
        'material_name',
        'vehicle_plat_number',
        'vehicle_type',
        'vehicle_max_capacity',
        'driver_name',
        'driver_contact',
        'qr_code',
        'date',
        'status',
    ];

    // public function vehicle()
    // {
    //     return $this->belongsTo(Vehicle::class);
    // }

    // public function material()
    // {
    //     return $this->belongsTo(Material::class);
    // }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // public function driver()
    // {
    //     return $this->belongsTo(Driver::class);
    // }

    /**
     * Scope a query to only include company deliveries.
     */
    public function scopeOf(Builder $query, $companyId): void
    {
        $query->where('company_id', $companyId);
    }

    /**
     * Scope a query to only include sent deliveries.
     */
    public function scopeSent(Builder $query): void
    {
        $query->where('status', 'Dikirim');
    }
}
