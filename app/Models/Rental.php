<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;
    protected $table = 'rental';
    protected $primaryKey = 'rental_id';
    public  $timestamps =false;

    protected $fillable = [
        'rental_date', 'inventory_id', 'customer_id', 'return_date', 'staff_id', 'last_update'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
