<?php

namespace App\Http\Controllers;

use App\Models\Carrier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CarrierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carrier=DB::table('carriers')->get();
        return view('carrier.carrier', ['Objs' => $carrier]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $obj = new Carrier();
        $obj->nombre = $request->input('nombre');
        $obj->descripcion = $request->input('descripcion');
        $obj->estatus_id = 1;
        $obj->save();
        $carrier=DB::table('carriers')->get();
        return view('carrier.carrier', ['Objs' => $carrier]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = carrier::find($id);
        if ($post) {
            $post->delete();
            return redirect()->route('carrier.index')->with('success', 'Post eliminado con éxito.');
        }

        return redirect()->route('carrier.index')->with('error', 'Post no encontrado.');
    }
}
