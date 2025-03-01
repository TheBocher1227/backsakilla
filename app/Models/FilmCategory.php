<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilmCategory extends Model
{
    use HasFactory;

    protected $table = 'film_category';
    protected $fillable = [
        'film_id', 'category_id', 'last_update'
    ];

    public function film()
    {
        return $this->belongsTo(Film::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

