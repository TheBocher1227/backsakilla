<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;
    protected $table = 'staff';
    protected $primaryKey = 'staff_id';
    public  $timestamps =false;

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
