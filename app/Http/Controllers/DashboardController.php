<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Truck;
class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trucks = truck::with(['relaciones.cliente', 'relaciones.contactoDirecto', 'relaciones.carrier', 'relaciones.rutas','latestbitcora.estatus'])->Paginate(5);
        return view('Dashboardtv',['trucks'=>$trucks]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function viewst()
    {
        $trucks = truck::with(['relaciones.cliente', 'relaciones.contactoDirecto', 'relaciones.carrier', 'relaciones.rutas','latestbitcora.estatus'])->Paginate(5);
        return view('Dashboard',['trucks'=>$trucks]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
