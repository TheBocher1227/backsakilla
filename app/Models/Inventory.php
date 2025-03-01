<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    protected $table = 'inventory'; 
    protected $primaryKey = 'inventory_id';

    protected $fillable = [
        'film_id', 'store_id', 'last_update'
    ];

    public function film()
    {
        return $this->belongsTo(Film::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }
}

