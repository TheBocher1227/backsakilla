<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    use HasFactory;
    protected $table = 'film';
    protected $primaryKey = 'film_id';
    public  $timestamps =false;

    protected $fillable = [
        'title', 'description', 'release_year', 'language_id', 'rental_duration', 'rental_rate', 'length', 'replacement_cost', 'rating', 'special_features', 'last_update', 'status'
    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('active', function ($query) {
            $query->where('status', true);
        });
    }

    public function language()
    {
        return $this->belongsTo(
            Language::class,
            'language_id', // 🔑 Columna en la tabla `film`
            'language_id'  // 🔑 Columna en la tabla `language`
        );
    }

    public function actors()
    {
        return $this->belongsToMany(Actor::class, 'film_actor', 'film_id', 'actor_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'film_category', 'film_id', 'category_id');
    }

    public function inventory()
    {
        return $this->hasMany(Inventory::class);
    }
}
