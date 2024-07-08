<?php

namespace App\Http\Controllers;

use App\Models\Bitacora;
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

        $trucks = truck::with(['relaciones.cliente', 'relaciones.contactoDirecto', 'relaciones.carrier', 'relaciones.rutas','latestbitcora.estatus'])->Paginate(5);

        return view('Dashboard', ['trucks' => $trucks]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $relaciones = relaciones::with(['cliente', 'contactoDirecto', 'carrier', 'rutas'])->get();

        return view('trucks.trucks', ['relaciones' => $relaciones]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $obj = new Truck();
        $obj->number_truck = $request->input('truck');
        $obj->number_container = $request->input('container');
        $obj->trailer_plates = $request->input('placas');
        $obj->operator_name = $request->input('OP');
        $obj->back_operator_name = $request->input('BOP');
        $obj->relaciones_id = $request->input('relaciones');
        $dateTime =  strtotime($request->input('fecha'));
        $obj->ETA = date('d/m/Y H:i:s',  $dateTime);
        $user = Auth::user()->id;
        $obj->user_id = $user;

        $obj->save();


        $bit = new Bitacora();
        $bit->truck_id = $obj->id;
        $bit->user_id = $user;
        $bit->estatus_id = 1;
        $bit->comentario = "creado ";
        $bit->save();
        $trucks = truck::with(['relaciones.cliente', 'relaciones.contactoDirecto', 'relaciones.carrier', 'relaciones.rutas','bitacora'])->Paginate(5);
        return view('dashboard', ['trucks' => $trucks]);
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
    public function update(Request $request)
    {
        $trucks = truck::with(['relaciones.cliente', 'relaciones.contactoDirecto', 'relaciones.carrier', 'relaciones.rutas','latestbitcora.estatus'])->Paginate(5);

        return view('Dashboard', ['trucks' => $trucks]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
