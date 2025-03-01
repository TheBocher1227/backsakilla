<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $table = 'payment';
    protected $primaryKey = 'payment_id';
    public  $timestamps =false;

    protected $fillable = [
        'customer_id', 'staff_id', 'rental_id', 'amount', 'payment_date'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function rental()
    {
        return $this->belongsTo(Rental::class);
    }
}
