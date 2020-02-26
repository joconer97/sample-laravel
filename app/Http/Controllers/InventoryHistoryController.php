<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InventoryHistory;
use Illuminate\Support\Facades\DB;

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
        $inventoryMonth = DB::select('SELECT X.item_id,MONTH(X.created_at)  AS date ,SUM(X.quantity) as total,Y.item_name FROM inventory_histories AS X
                                        JOIN ITEMS AS Y ON Y.id = X.item_id
                                        GROUP BY MONTH(X.created_at),X.item_id', [1]);

        $inventoryDay = DB::select('SELECT X.item_id,DAY(X.created_at) as day,MONTH(X.created_at) as month,SUM(X.quantity) AS total,Y.item_name
                                    FROM INVENTORY_HISTORIES AS X
                                    JOIN ITEMS AS Y ON Y.ID = X.item_id
                                    WHERE MONTH(X.created_at) = MONTH(NOW())
                                    GROUP BY X.item_id,DAY(X.created_at),MONTH(X.created_at)
                                    ORDER BY MONTH(X.created_at),DAY(X.created_at)', [1]);

        return response()->json([
            'inventoryMonth' => $inventoryMonth,
            'inventoryDay' => $inventoryDay
        ],200);
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
