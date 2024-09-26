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
        $carrier = Carrier::where('estatus_id','1')->where('estatus_id','!=',7)->paginate(10);
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
        $carrier = DB::table('carriers')->where('estatus_id','!=',7)->paginate(10);
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
        $updated = DB::table('carriers')
        ->where('id', $id)
        ->update(['estatus_id' => 7]);


   return redirect()->route('Carrier.index')->with('success', 'cliente eliminado con éxito.');
    }
}
