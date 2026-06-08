<?php

use App\Models\Location\Location;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;

if (! function_exists('set_location')) {

    function set_location($locationId)
    {
        $location = Location::with('parent')->find($locationId);

        if (! $location) {
            return false;
        }

        Cookie::queue('location_id', $location->id);

        return true;
    }
}

if (! function_exists('get_location')) {

    function get_location()
    {
        $locationId = request()->cookie('location_id');

        if (! $locationId) {
            $lat = request()->cookie('user_lat');
            $lng = request()->cookie('user_lng');

            if ($lat && $lng && $lat !== 'failed' && $lng !== 'failed') {
                try {
                    $nearestCity = Location::where('type', 'city')
                        ->where('latitude', '!=', '')
                        ->where('longitude', '!=', '')
                        ->select('id')
                        ->selectRaw(
                            '(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance',
                            [$lat, $lng, $lat]
                        )
                        ->orderBy('distance')
                        ->first();

                    if ($nearestCity) {
                        $locationId = $nearestCity->id;
                        set_location($locationId);
                    }
                } catch (\Exception $e) {
                    // Ignore and fallback
                }
            }

            if (! $locationId) {
                // Default to a city in Punjab (parent_id = 29) or 1
                $defaultCity = Location::where('parent_id', 29)->where('type', 'city')->first();
                $locationId = $defaultCity ? $defaultCity->id : 1;
                set_location($locationId);
            }
        }
        return Location::with('parent')->find($locationId);
    }
}