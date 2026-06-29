<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location\Location;
use DB;
use Str;

class DevController extends Controller
{

    public function ss()
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

    public function index(Request $req)
    {
        // die();
        $cities = DB::table('cities')
            ->orderBy('city', 'asc')
            ->get();

        foreach ($cities as $city) {

            $state = DB::table('states')
                ->where('id', $city->state_id)
                ->first();

            $location = DB::table('locations')
                ->where('name', $state->name)
                ->first();    

            Location::create([
                    'name' => $city->city,
                    'slug' => Str::slug($city->city),
                    'type' => 'city',
                    'parent_id' => $location->id,
                    'latitude' => $city->latitude,
                    'longitude' => $city->longitude
                ]);
          
        }
        dd('done');
    }

}
