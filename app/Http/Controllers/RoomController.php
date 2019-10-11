<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $rooms = Room::all();

        foreach($rooms as $room)
        {
            $room->beds = Room::find($room->id)->beds;
        }

        return response()->json([
            'rooms' => $rooms
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
        $room = Room::create(['room_name' => $request->roomName,'room_details' => $request->roomDetails,'price' => $request->price,'capacity' => $request->roomCapacity]);
        
        if($room != null)
        {
            foreach($request->beds as $bed)
            {
                // print_r($bed);
                $room->beds()->attach($bed['id'],['quantity' => $bed['quantity']]);
            }
        }

        return response()->json([
            'room' =>  $room
        ],200);



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function show(Room $room)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function edit(Room $room)
    {
        //

        return response()->json([
            'room' => $room
        ],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        //
        $room = Room::find($id);
        $room->room_name = $request->room_name;
        $room->room_details = $request->room_details;
        $room->price = $request->price;
        $room->capacity = $request->capacity;
        $room->save();

        $room->beds()->detach();

        foreach($request->beds as $bed)
        {
            // print_r($bed);
            $room->beds()->attach($bed['id'],['quantity' => $bed['pivot']['quantity']]);
        }

        return response()->json([
            'room' => $room,
        ],200);

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $room = Room::find($id)->delete();

        return response()->json([
            'room' => $room
        ],200);
    }
}
