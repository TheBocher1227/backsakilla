<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;
    protected $table = 'language';
    protected $primaryKey = 'language_id';
    public  $timestamps =false;
    protected $fillable = [
        'name', 'last_update'
    ];

    public function films()
    {
        return $this->hasMany(Film::class);
    }
}
