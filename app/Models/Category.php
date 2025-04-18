<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'category';
    protected $primaryKey = 'category_id';
    public  $timestamps =false;

    protected $fillable = [
        'name', 'last_update'
    ];

    public function films()
{
    return $this->belongsToMany(
        Film::class,
        'film_category',
        'category_id', // columna en film_category que referencia a Category
        'film_id'      // columna en film_category que referencia a Film
    );
}

}

