<?php

namespace App\Http\Controllers;

use App\Models\Rutas;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class RutaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Truta=DB::table('tipo_de_ruta')->get()->toArray();
        $tabla=DB::table('Rutas')->get();

        return view('ruta.Ruta', ['Truta' => $Truta,'Objs' => $tabla]);

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

        $obj = new Rutas();
        $obj->nombre = $request->input('nombre');
        $obj->descripcion = $request->input('descripcion');
        $obj->tipo_de_ruta_id= $request->input('truta');
        $obj->estatus_id = '1';
        $obj->save();
        $tabla=DB::table('rutas')->get();
        $Truta=DB::table('tipo_de_ruta')->get()->toArray();
        return view('ruta.ruta', ['Truta' => $Truta,'Objs' => $tabla]);
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
        $post = Rutas::find($id);

        if ($post) {
            $post->delete();
            return redirect()->route('Ruta.index')->with('success', 'Post eliminado con éxito.');
        }

        return redirect()->route('Ruta.index')->with('error', 'Post no encontrado.');

    }
}
