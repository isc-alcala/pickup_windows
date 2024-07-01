<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = DB::table('clientes')->get();

        return view('cliente.Cliente', ['clientes' => $clientes]);
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

        $cliente = new Cliente();
        $cliente->nombre = $request->input('nombre');
        $cliente->descripcion = $request->input('descripcion');
        $cliente->proyectos = $request->input('proyectos');
        $cliente->type_supplier_id = $request->input('Type');
        $cliente->save();
        $clientes = DB::table('clientes')->get();
        return view('cliente.Cliente', ['clientes' => $clientes]);
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

        $post = cliente::find($id);

        if ($post) {
            $post->delete();
            return redirect()->route('cliente.index')->with('success', 'Post eliminado con éxito.');
        }

        return redirect()->route('cliente.index')->with('error', 'Post no encontrado.');
    }
}
