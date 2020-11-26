<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Parents;
use App\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ParentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parents = Parents::with(['addresses', 'addresses.country'])
            ->get();

        return response()->json([
            'parents' => $parents
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $parent = $request->all();

        $validator = Validator::make($parent, [
            'full_name' => 'required',
            'mobile_no' => 'required',
            'home_no' => 'required',
            'email' => 'unique:App\Parents,email'
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        $parent = new Parents();
        $parent->full_name = $request->full_name;
        $parent->mobile_no = $request->mobile_no;
        $parent->home_no = $request->home_no;
        $parent->email = $request->email;
        $parent->nric = $request->nric;
        $parent->job = $request->job;
        $parent->type = $request->type;
        $parent->save();

        $parentId = Parents::with(['addresses', 'addresses.country'])
            ->where('parents.email', '=', $request->email)
            ->first()
            ->id;

        if ($request->addresses) {
            $address = new Address();
            $address->address_street_1 = $request->addresses['address_street_1'];
            $address->address_street_2 = $request->addresses['address_street_2'];
            $address->city = $request->addresses['city'];
            $address->state = $request->addresses['state'];
            $address->country_id = $request->addresses['country_id'];
            $address->zip = $request->addresses['zip'];
            $address->phone = $request->addresses['phone'];
            $address->addressable_id = $parentId;
            $address->addressable_type = 'App\Parents';
            $address->save();
            $parent->addresses()->save($address);
        }

        return response()->json([
            'success' => true,
            'parent' => $parent
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Parents  $parents
     * @return \Illuminate\Http\Response
     */
    public function show(Parents $parent)
    {
        $parent = Parents::with(['addresses', 'addresses.country'])
            ->find($parent->id);

        return response()->json([
            'parents' => $parent
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Parents  $parents
     * @return \Illuminate\Http\Response
     */
    public function edit(Parents $parent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Parents  $parents
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Parents $parents)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Parents  $parents
     * @return \Illuminate\Http\Response
     */
    public function destroy(Parents $parents)
    {
        //
    }
}
