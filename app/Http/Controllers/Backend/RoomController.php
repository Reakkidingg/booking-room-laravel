<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\RoomType;
use Exception;
use Illuminate\Database\QueryException;
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
            ->where('room_active', '1')
            ->orderBy('room_id', 'desc')
            ->paginate(config('app.row'));
        // ->get();
        return view('backend.room.index', $data);
    }

    public function create()
    {
        $room_types = DB::table('room_types')->get();

        // $room_types = RoomType::all();
        return view('backend.room.create', compact('room_types'));
    }

    public function save(Request $rep)
    {
        $rep->validate(
            [
                'room_name' => 'required|unique:rooms|max:191',
                //'room_status' => 'required',
                'room_desc' => 'required',
                'room_type_id' => 'required',
                'room_photo' => 'required'
            ],
            [
                'room_name.required' => 'Please input the field room name!',
                'room_desc.required' => 'Please input the field room description!',
                'room_type_id.required' => 'Please input the field room type ID!',
                'room_photo.required' => 'Please select photo from your browse!',
            ]
        );

        if ($rep->room_photo) {
            $data['room_photo'] = $rep->file('room_photo')->store('uploads/rooms/', 'custom');
        }
        try {
            // Extracting data from the request
            $data = array(
                'room_name' => $rep->room_name,
                'room_desc' => $rep->room_desc,
                'room_status' => $rep->room_status,
                'room_photo' => $data['room_photo'],
                'room_type_id' => $rep->room_type_id,
            );

            $existingRoom = DB::table('rooms')->where('room_name', $data['room_name'])->first();

            if ($existingRoom) {
                return back()->with('duplicate', 'The room name already exists. Please use a different name.');
            }
            // Inserting data into the 'rooms' table
            $i = DB::table('rooms')->insert($data);

            if ($i) {
                return redirect('/room')->with('success', 'Data has been inserted.');
            }
        } catch (QueryException $e) {

            return back()->with('error', 'Insert data went wrong!');
        }
    }

    //Delete Function
    public function delete($id)
    {
        $i = DB::table('rooms')
            ->where('room_id', $id)
            // ->delete();
            ->update(['room_active' => '0']);
        return redirect('room')->with('success', 'Data has been deleted.');
    }

    //Update Function
    public function edit($id)
    {
        $data['rooms'] = DB::table('rooms')
            ->where('room_id', $id)
            ->first();

        $room_types = RoomType::all();
        return view('backend.room.edit', $data, compact('room_types'));
    }


    // Update
    public function update(Request $req)
    {
        // Exclude the unnecessary fields from the request data
        $data = $req->except('_token', 'room_id', 'room_photo');

        // Check if a new room photo has been uploaded
        if ($req->room_photo) {
            // Store the new room photo and update the data array
            $data['room_photo'] = $req->file('room_photo')->store('uploads/rooms/', 'custom');
        }

        $existingRoom = DB::table('rooms')->where('room_name', $data['room_name'])->first();

        if ($existingRoom) {
            return back()->with('duplicate', 'The room name already exists. Please use a different name.');
        }

        // Update the room data in the database
        $i = DB::table('rooms')
            ->where('room_id', $req->room_id)
            ->update($data);

        if ($i) {
            return redirect('room/edit/' . $req->room_id)
                ->with('success', 'Data has been updated!');
        } else {
            return redirect('room/edit/' . $req->room_id)
                ->with('error', 'Failed Data to updated!');
        }
    }
}
