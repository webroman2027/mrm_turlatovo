<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use App\Http\Resources\FlightResource;
use App\Models\Flight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FlightController extends BaseController
{
    public function getFlights(Request $request){

        $validator = Validator::make($request->all(), [
            'from' => 'required',
            'to' => 'required',
            'date1' => 'required|date',
            'date2' => 'date',
            'passengers' => 'required|digits_between:1,8'
        ]);

        if ($validator->fails()) {
           return $this->sendErrorResponse($validator);
        }

        $validated = $validator->validated();

        $from = AirportController::getAirport($validated['from']);
        $to = AirportController::getAirport($validated['to']);

        $flightTo = Flight::where('from_id', $from[0]['id'])->where('to_id', $to[0]['id'])->get();

        if (isset($validated['date2'])) {
            $flightBack = Flight::where('from_id', $to[0]['id'])->where('to_id', $from[0]['id'])->get();
        }


        return FlightResource::collection($flightTo);

    }

}
