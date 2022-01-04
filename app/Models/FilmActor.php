<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class FilmActor extends Pivot
{
    use HasFactory;
    public $timestamps = false;
    protected $dates=['last_update'];

    public function actor(){
        return $this->hasOne(Actor::class, 'actor_id' , 'actor_id');
    }

    public function film(){
        return $this->hasOne(Film::class, 'film_id' , 'film_id');
    }
}
