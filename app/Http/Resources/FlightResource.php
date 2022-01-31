<?php

namespace App\Http\Resources;

use App\Models\Airport;
use Illuminate\Http\Resources\Json\JsonResource;

class FlightResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $airport = Airport::find($this->from_id);
        $airport['date'] =  $request->date1;
        $airport['time'] = $this->time_from;

        return [
            'flights_to' => [
                'flight_id' => $this->id,
                'flight_code' => $this->flight_code,
                'from' => $airport,
                'cost' => $this->cost,
            ],
        ];
    }
}
