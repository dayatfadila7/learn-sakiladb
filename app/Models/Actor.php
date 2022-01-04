<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'actor';
    protected $primaryKey = 'actor_id';
    protected $appends = [
        'full_name'
    ];

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function films()
    {
        return $this->belongsToMany(Film::class, 'film_actor', 'actor_id', 'film_id');
    }

}
