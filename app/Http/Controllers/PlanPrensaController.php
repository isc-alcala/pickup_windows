<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Imports\MyDataImport;
use App\Imports\MyDataImport2;
use Maatwebsite\Excel\Facades\Excel;

class PlanPrensaController extends Controller
{
    public function index()
    {
        return view('IOT.forms',[]);
  
    }

    public function import(Request $request)
    {
        // Validar que el archivo ha sido subido
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        // Procesar el archivo
        try {
            Excel::import(new MyDataImport, $request->file('file'));

            return response()->json(['success' => 'Archivo importado exitosamente']);
        } catch (Exception $e) {
            return response()->json(['error' => 'Error al importar el archivo: ' . $e->getMessage()], 500);
        }
    }

    public function import2(Request $request)
    {
        // Validar que el archivo ha sido subido
        $request->validate([
            'file2' => 'required|mimes:xls,xlsx'
        ]);

        // Procesar el archivo
        try {
            Excel::import(new MyDataImport2, $request->file('file2'));

            return response()->json(['success' => 'Archivo importado exitosamente']);
        } catch (Exception $e) {
            return response()->json(['error' => 'Error al importar el archivo: ' . $e->getMessage()], 500);
        }
    }
}