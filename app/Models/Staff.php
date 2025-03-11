<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Staff extends Model
{
    use HasFactory;
    protected $table = 'staff';
    protected $primaryKey = 'staff_id';
    public  $timestamps =false;

    protected static function booted()
    {
        static::addGlobalScope('active', function (Builder $builder) {
            $builder->where('active', true);
        });
    }

    protected $fillable = [
        'first_name', 'last_name', 'address_id', 'email', 'store_id', 'active', 'username', 'password', 'last_update','picture'
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
