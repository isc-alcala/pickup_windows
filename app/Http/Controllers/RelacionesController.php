<?php

namespace App\Http\Controllers;

use App\Models\Relaciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RelacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $truta = DB::table('Rutas')->get();
        $tcliente = DB::table('Clientes')->get();
        $tcontactodirecto = DB::table('Contacto_directo')->get();

        $carrier = DB::table('carriers')->get();
        $trelaciones = Relaciones::with([ 'cliente', 'contactoDirecto', 'carrier','rutas'])->get();

        return view('relaciones.relaciones', ['Trelaciones' => $trelaciones, 'rutas' => $truta, 'contactodirectos' => $tcontactodirecto, 'carriers' => $carrier, 'clientes' => $tcliente]);
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

        $obj = new Relaciones();
        $obj->contacto_directo_id = $request->input('CD');
        $obj->Ruta_id = $request->input('ruta');
        $obj->carrier_id = $request->input('carrier');
        $obj->cliente_id = $request->input('cliente');
        $user = Auth::user()->id;
        $obj->user_id = $user;

        $obj->save();

        $truta = DB::table('Rutas')->get();
        $tcliente = DB::table('Clientes')->get();
        $tcontactodirecto = DB::table('Contacto_directo')->get();

        $carrier = DB::table('carriers')->get();
        $trelaciones = Relaciones::with(['rutas', 'cliente', 'contactoDirecto', 'carrier'])->get();
        return view('relaciones.relaciones', ['Trelaciones' => $trelaciones, 'rutas' => $truta, 'contactodirectos' => $tcontactodirecto, 'carriers' => $carrier, 'clientes' => $tcliente]);
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
