<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    protected $table = 'country';
    protected $primaryKey = 'country_id';
    public  $timestamps =false;

    protected $fillable = [
        'country', 'last_update'
    ];

    public function cities()
{
    return $this->hasMany(
        City::class,
        'country_id',   // Clave foránea en la tabla `city`
        'country_id'    // Clave primaria en la tabla `country`
    );
}

}
