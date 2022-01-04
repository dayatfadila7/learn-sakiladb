<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use App\Models\Film;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FilmController extends Controller
{
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
