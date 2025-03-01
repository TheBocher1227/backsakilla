<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $table = 'adress';
    protected $primaryKey = 'adress_id';

    protected $fillable = [
        'address', 'address2', 'district', 'city_id', 'postal_code', 'phone', 'last_update'
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function staff()
    {
        return $this->hasMany(Staff::class);
    }

    public function stores()
    {
        return $this->hasMany(Store::class);
    }
}
