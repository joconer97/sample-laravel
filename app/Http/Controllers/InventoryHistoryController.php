<?php

namespace App\Http\Controllers;

use App\Models\InventoryHistory;
use Illuminate\Http\Request;

class InventoryHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $inventory = new InventoryHistory();
        $inventory->item_id = $request->item_id;
        $inventory->status = $request->status;
        $inventory->quantity = $request->quantity;
        $inventory->save();

        return response()->json([
            'inventory' => $inventory
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InventoryHistory  $inventoryHistory
     * @return \Illuminate\Http\Response
     */
    public function show(InventoryHistory $inventoryHistory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InventoryHistory  $inventoryHistory
     * @return \Illuminate\Http\Response
     */
    public function edit(InventoryHistory $inventoryHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InventoryHistory  $inventoryHistory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InventoryHistory $inventoryHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InventoryHistory  $inventoryHistory
     * @return \Illuminate\Http\Response
     */
    public function destroy(InventoryHistory $inventoryHistory)
    {
        //
    }
}
