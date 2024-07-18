<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\ContactoDirecto;
class ContactoDirectoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tabla=DB::table('contacto_directo')->get();
        return view('contacto_directo.contacto_directo', ['Objs' => $tabla]);

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
        $obj = new ContactoDirecto();
        $obj->nombre = $request->input('nombre');
        $obj->descripcion = $request->input('descripcion');
        $obj->estatus_id = 1;
        $obj->save();
        $tabla=DB::table('contacto_directo')->get();
        return view('contacto_directo.contacto_directo', ['Objs' => $tabla]);
    }


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