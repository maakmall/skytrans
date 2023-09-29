<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
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
        'address',
    ];

    public function materials()
    {
        return $this->hasMany(CompanyMaterial::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
