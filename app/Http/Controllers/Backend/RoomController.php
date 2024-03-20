<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\RoomType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{
    public function index()
    {

        $data['rooms'] = DB::table('rooms')
            // ->where('room_status', '0')
            ->join('room_types', 'room_types.room_type_id', '=', 'rooms.room_type_id')
            ->select('rooms.*', 'room_types.room_type_name')
            ->orderBy('room_id', 'desc')
            ->paginate(config('app.row'));
        // ->get();
        return view('backend.room.index', $data);
    }

    public function create()
    {
        // $room_types = DB::table('room_types')->get();

        $room_types = RoomType::all();
        return view('backend.room.create', compact('room_types'));
    }

    public function save(Request $rep)
    {
        try {
            // Extracting data from the request
            $data = array(
                'room_name' => $rep->room_name,
                'room_desc' => $rep->room_desc,
                'room_status' => $rep->room_status,
                'room_type_id' => $rep->room_type_id,
            );

            // Check if the room_name already exists in the database
            $existingRoom = DB::table('rooms')->where('room_name', $data['room_name'])->first();

            if ($existingRoom) {
                return back()->with('duplicate', 'The room name already exists. Please use a different name.');
            }
            // Inserting data into the 'rooms' table
            $i = DB::table('rooms')->insert($data);

            if ($i) {
                return redirect('room/create')->with('success', 'Data has been inserted.');
            }
        } catch (Exception $e) {
            
            return back()->with('error', 'Insert data went wrong!');
        }
    }
}
