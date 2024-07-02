<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Relaciones;
use App\Models\Truck;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
class TruckController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $trucks = truck::with([ 'relaciones.cliente', 'relaciones.contactoDirecto', 'relaciones.carrier','relaciones.rutas'])->get();
        return view('Dashboard', ['trucks' => $trucks]);
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
        $obj = new Truck();
        $obj->number_truck = $request->input('truck');
        $obj->number_container= $request->input('container');
        $obj->trailer_plates= $request->input('placas');
        $obj->operator_name = $request->input('OP');
        $obj->back_operator_name = $request->input('BOP');
        $obj->relaciones_id = $request->input('relaciones');
        $dateTime =  strtotime($request->input('fecha'));
         $obj->ETA = date('d/m/Y H:i:s',  $dateTime);



        $user = Auth::user()->id;




        $obj->user_id = $user;

        $idtreck=$obj->save();
        dd(  $idtreck);



        $truck= Truck::with([ 'cliente', 'contactoDirecto', 'carrier','rutas'])->get();
        dd(  $truck);
        return view('dashboard', ['Trucks' => $truck]);

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
        //
    }
}
