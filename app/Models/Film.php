<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    use HasFactory;

    protected $table = 'film';
    protected $primaryKey ='film_id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    protected $dates =[
        'last_update'
    ];

    public function actors()
    {
        return $this->belongsToMany(Actor::class,'film_actor','film_id','actor_id');
    }
}
