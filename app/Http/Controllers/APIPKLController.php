<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PKL;

class APIPKLController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pkl = PKL::get();
        return response()->json($pkl, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $pkl = new PKL();
        $pkl->siswa_id = $request->siswa_id;
        $pkl->industri_id = $request->industri_id;
        $pkl->guru_id = $request->guru_id;
        $pkl->mulai = $request->mulai;
        $pkl->selesai = $request->selesai;
        $pkl->save();

        return response()->json($pkl, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pkl = PKL::find($id);
        return response()->json($pkl, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pkl = PKL::find($id);
        $pkl->siswa_id = $request->siswa_id;
        $pkl->industri_id = $request->industri_id;
        $pkl->guru_id = $request->guru_id;
        $pkl->mulai = $request->mulai;
        $pkl->selesai = $request->selesai;
        $pkl->save();

        return response()->json($pkl, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        PKL::destroy($id);
        return response()->json(['message' => 'PKL deleted successfully'], 200);
    }
}
