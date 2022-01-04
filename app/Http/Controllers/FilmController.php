<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use App\Models\Film;
use Carbon\Carbon;
use Illuminate\Http\Request;


/**
 * @group A. Actors Films
 *
 * APIs for Actors Films
 **/
class FilmController extends Controller
{
    /**
     * Get Data Film By Actor Id
     *
     * @urlParam id integer ID Actor. Example: 1
     *
     * @response
     * {
     *  "message": "OK",
     *  "data": [
     *      {
     *      "film_id": 5,
     *      "title": "AFRICAN EGG",
     *      "description": "A Fast-Paced Documentary of a Pastry Chef And a Dentist who must Pursue a Forensic Psychologist in The Gulf of Mexico",
     *      "release_year": 2006,
     *      "language_id": 1,
     *      "original_language_id": null,
     *      "rental_duration": 6,
     *      "rental_rate": "2.99",
     *      "length": 130,
     *      "replacement_cost": "22.99",
     *      "rating": "G",
     *      "special_features": "Deleted Scenes",
     *      "last_update": "2006-02-15T05:03:42.000000Z"
     *      },
     *      {
     *      "film_id": 49,
     *      "title": "BADMAN DAWN",
     *      "description": "A Emotional Panorama of a Pioneer And a Composer who must Escape a Mad Scientist in A Jet Boat",
     *      "release_year": 2006,
     *      "language_id": 1,
     *      "original_language_id": null,
     *      "rental_duration": 6,
     *      "rental_rate": "2.99",
     *      "length": 162,
     *      "replacement_cost": "22.99",
     *      "rating": "R",
     *      "special_features": "Trailers,Commentaries,Behind the Scenes",
     *      "last_update": "2006-02-15T05:03:42.000000Z"
     *      },
     *      {
     *      "film_id": 80,
     *      "title": "BLANKET BEVERLY",
     *      "description": "A Emotional Documentary of a Student And a Girl who must Build a Boat in Nigeria",
     *      "release_year": 2006,
     *      "language_id": 1,
     *      "original_language_id": null,
     *      "rental_duration": 7,
     *      "rental_rate": "2.99",
     *      "length": 148,
     *      "replacement_cost": "21.99",
     *      "rating": "G",
     *      "special_features": "Trailers",
     *      "last_update": "2006-02-15T05:03:42.000000Z"
     *      }
     *   ]
     * }
     */
    public function actorFilm(Request $request, $id)
    {
        $films = Film::wherehas('actors', function ($q) use ($id) {
            $q->where('actor.actor_id', $id);
        })->get();

        $data = [
            'message' => 'Data not found',
            'data' => null,
        ];

        if (!empty($films)) {
            $data = [
                'message' => 'OK',
                'data' => $films,
            ];
        }

        return response()->json($data);
    }

    /**
     * Add Data Actor to Film
     *
     * @urlParam id integer ID Actor. Example: 1
     * @bodyParam film integer[] This is a id film. Example: [3, 6]
     * @response
     * {
     * "message": "OK",
     * }
     */
    public function addActorFilm(Request $request, $id)
    {
        $now = Carbon::now();
        $actor = Actor::find($id);
        //remove data first, for handle Integrity constraint violation duplicate entry
        $actor->films()->detach($request->film);
        //add Actor X to  Film Y
        $data = $actor->films()->attach($request->film, ['last_update' => $now]);

        return response()->json([
            'message' => 'OK',
        ]);
    }

    /**
     * Get Data Total Film Groub By Actor
     *
     * @response
     * {
     * "message": "OK",
     * "data": [
     *      {
     *      "name": "PENELOPE GUINESS",
     *      "total": 21
     *      },
     *      {
     *      "name": "NICK WAHLBERG",
     *      "total": 25
     *      },
     *      {
     *      "name": "ED CHASE",
     *      "total": 22
     *      }
     *   ]
     * }
     */
    public function totalFilmActor(Request $request)
    {
        $actors = Actor::withCount('films')->get();

        $items = [];

        foreach ($actors as $actor) {
            $items[] = [
                'name' => $actor->full_name,
                'total' => $actor->films_count,
            ];
        }

        $data = [
            'message' => 'Data not found',
            'data' => null,
        ];

        if (!empty($actors)) {
            $data = [
                'message' => 'OK',
                'data' => $items,
            ];
        }

        return response()->json($data);
    }
}
