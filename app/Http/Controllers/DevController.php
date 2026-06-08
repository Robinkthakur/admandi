<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location\Location;
use DB;
use Str;

class DevController extends Controller
{

    public function index()
    {
        // Main city
        $selectedCity = Location::where('name', 'Thanesar')->first();

        if (!$selectedCity) {
            return response()->json([
                'success' => false,
                'message' => 'City not found'
            ]);
        }

        // Get nearby cities
        $nearbyCities = Location::selectRaw("
                id,
                name,
                parent_id,
                latitude,
                longitude,

                (
                    6371 * acos(
                        cos(radians(?))
                        * cos(radians(latitude))
                        * cos(radians(longitude) - radians(?))
                        + sin(radians(?))
                        * sin(radians(latitude))
                    )
                ) AS distance
            ", [
                $selectedCity->latitude,
                $selectedCity->longitude,
                $selectedCity->latitude,
            ])

            // Exclude current city
            ->where('id', '!=', $selectedCity->id)

            // Optional:
            // only nearby within 100km
            ->having('distance', '<=', 20)

            ->orderBy('distance')

            ->limit(20)

            ->get();

        return response()->json([
            'success' => true,
            'selected_city' => [
                'id' => $selectedCity->id,
                'name' => $selectedCity->name,
                'latitude' => $selectedCity->latitude,
                'longitude' => $selectedCity->longitude,
            ],
            'nearby_cities' => $nearbyCities
        ]);
    }

    public function indexOLD(Request $req)
    {
        die();
        $states = DB::table('cities')
            ->orderBy('name', 'asc')
            ->get();

        foreach ($states as $state) {

          
            Location::where('name', $state->name)
                ->where('type' , 'city')
                ->update([
                    'latitude' => $state->latitude,
                    'longitude' => $state->longitude
                ]);
          
        }
        dd('done');
    }

}
