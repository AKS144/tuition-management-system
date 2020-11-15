<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Item;
use App\TaxType;
use App\Tax;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = $request->has('limit') ? $request->limit : 10;

        $items = Item::with(['taxes'])
            ->leftJoin('units', 'units.id', '=', 'items.unit_id')
            ->applyFilters($request->only([
                'search',
                'price',
                'unit_id',
                'orderByField',
                'orderBy'
            ]))
            ->whereBranch($request->header('branch'))
            // ->where('branch_id', $request->header('branch'))
            ->select('items.*', 'units.name as unit_name')
            ->latest()
            ->paginate($limit);

        return response()->json([
            'items' => $items,
            'taxTypes' => TaxType::latest()->get()
        ]);
    }

    public function edit(Request $request, $id)
    {
        $item = Item::with(['taxes', 'unit'])->find($id);

        return response()->json([
            'item' => $item,
            'taxes' => Tax::whereBranch($request->header('branch'))
                ->latest()
                ->get()
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
        $items = $request->all();

        $validator = Validator::make($items, [
            'name' => 'required',
            'price' => 'required',
        ]);

        if($validator->fails()){
            return response([
                'status' => false,
                'error' => $validator->errors(),
                'message' => 'Validation Error'
            ], 401);
        }
        
        $item = new Item();
        $item->name = $request->name;
        $item->unit_id = $request->unit_id;
        $item->description = $request->description;
        $item->branch_id = $request->header('branch');
        $item->price = $request->price;
        $item->save();

        if ($request->has('taxes')) {
            foreach ($request->taxes as $tax) {
                $tax['branch_id'] = $request->header('branch');
                $item->taxes()->create($tax);
            }
        }

        $item = Item::with('taxes')->find($item->id);

        return response()->json([
            'item' => $item
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        $items = $request->all();

        $validator = Validator::make($items, [
            'name' => 'required',
            'price' => 'required',
        ]);

        if($validator->fails()){
            return response([
                'status' => false,
                'error' => $validator->errors(),
                'message' => 'Validation Error'
            ], 401);
        }

        $item = Item::find($id);
        $item->name = $request->name;
        $item->unit_id = $request->unit_id;
        $item->description = $request->description;
        $item->price = $request->price;
        $item->save();

        $oldTaxes = $item->taxes->toArray();

        foreach ($oldTaxes as $oldTax) {
            Tax::destroy($oldTax['id']);
        }

        if ($request->has('taxes')) {
            foreach ($request->taxes as $tax) {
                $tax['branch_id'] = $request->header('branch');
                $item->taxes()->create($tax);
            }
        }

        $item = Item::with('taxes')->find($item->id);

        return response()->json([
            'item' => $item
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Item::deleteItem($id);

        if (!$data) {
            return response()->json([
                'error' => 'item_attached'
            ]);
        }

        return response()->json([
            'success' => $data
        ]);
    }

    /**
     * Delete a list of existing Items.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        $items = [];
        foreach ($request->id as $id) {
            $item = Item::deleteItem($id);
            if ($item) {
                array_push($items, $id);
            }
        }

        if (empty($items)) {
            return response()->json([
                'success' => true
            ]);
        }

        return response()->json([
            'items' => $items
        ]);
    }
}
