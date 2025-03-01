<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilmText extends Model
{
    use HasFactory;
    protected $table = 'film_text';

    protected $fillable = [
        'film_id', 'title', 'description'
    ];

    public function film()
    {
        return $this->belongsTo(Film::class);
    }
}
