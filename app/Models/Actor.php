<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    use HasFactory;
    protected $table = 'actor';
    protected $primaryKey = 'actor_id';
    public $timestamps = false;
    public $incrementing = true;

    protected $fillable = [
        'first_name', 'last_name', 'last_update', 'status'
    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('active', function ($query) {
            $query->where('status', true);
        });
    }

    public function films()
    {
        return $this->belongsToMany(Film::class, 'film_actor', 'actor_id', 'film_id');
    }
}
