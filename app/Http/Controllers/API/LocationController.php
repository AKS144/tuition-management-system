<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Country;

class LocationController extends Controller
{
    /**
     * Retrive a list of Countries.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCountries()
    {
        return response()->json([
            'countries' => Country::all()
        ]);
    }
}
