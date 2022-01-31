<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Airport;
use App\Http\Resources\AirportResource;

class AirportController extends Controller
{
    public function searchAirport(Request $request){
        $query = $request->query()['query'];

        $airport = self::getAirport($query);

        return response()->json(['data' => [
            'items' => AirportResource::collection($airport),
        ]]);
    }

    public static function getAirport($query){
        $airport = Airport::where('iata', $query)->orWhere('name', 'LIKE', "%{$query}%")
        ->orWhere('city', 'LIKE', "%{$query}%")->get();

        return $airport;
    }
}
