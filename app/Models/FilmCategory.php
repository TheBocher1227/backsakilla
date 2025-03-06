<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilmCategory extends Model
{
    use HasFactory;

    protected $table = 'film_category';

    public  $timestamps =false;
    protected $fillable = [
        'film_id', 'category_id', 'last_update'
    ];

    public function film()
    {
        return $this->belongsTo(
            Film::class,
            'film_id',      // Columna en film_category
            'film_id'       // Columna en film (PK de Film)
        );
    }

    public function category()
    {
        return $this->belongsTo(
            Category::class,
            'category_id',     // Columna en film_category
            'category_id'      // Columna en category (PK de Category)
        );
    }
}

