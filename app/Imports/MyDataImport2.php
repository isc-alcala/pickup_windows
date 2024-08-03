<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Exception;

class MyDataImport2 implements ToCollection
{
    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        // Empezar una transacción para asegurar atomicidad
        DB::beginTransaction();

        try {
            foreach ($rows as $index => $row) {
                // Omitir la fila de encabezado si la hay
                if ($index == 0) {
                    continue;
                }

                // Obtener solo las primeras 4 columnas
                $row = $row->take(4);

                // Verificar si la fila tiene datos en las primeras 4 columnas
                if ($this->hasData($row)) {
                    // Convertir el número serial a fecha
                    $fecha = $this->convertSerialToDate($row[3]); // Supón que el número serial está en la columna

                    // Validar los datos de la fila
                    // $validator = Validator::make($row->toArray(), [
                    //     '0' => 'required|integer',
                    //     '1' => 'required|string|max:255',
                    //     '2' => 'required|integer',
                    //     '3' => 'required|string|max:255',
                    //     '4' => 'required|date', // La fecha ya está convertida, así que podrías validar el formato aquí
                    // ]);

                    // // Si la validación falla, lanzar una excepción
                    // if ($validator->fails()) {
                    //     throw new Exception('La validación de los datos falló en la fila ' . ($index + 1));
                    // }

                    DB::statement('EXEC InsertOrUpdatePlanPrensasCP ?, ?, ?, ?', [
                        $row[0], // PLAN_MMVO
                        $row[1], // PLAN_CP
                        $row[2], // TURNO
                        $row[3]   // FECHA
                    ]);
                }
            }

            // Confirmar la transacción si todo fue exitoso
            DB::commit();
        } catch (Exception $e) {
            // Revertir la transacción en caso de error
            DB::rollBack();
            // Registrar o manejar el error según sea necesario
            throw $e;
        }
    }

    /**
     * Verificar si la fila tiene datos
     *
     * @param array $row
     * @return bool
     */
    private function hasData($row)
    {
        // Verificar si al menos una celda en las primeras 5 columnas tiene un valor no vacío
        return array_filter($row->toArray(), function($value) {
            return !empty($value);
        });
    }

    /**
     * Convertir número serial a fecha
     *
     * @param int $serialNumber
     * @return string
     */
    private function convertSerialToDate($serialNumber)
    {
        // Crear la fecha base de Excel (1 de enero de 1900)
        $baseDate = \Carbon\Carbon::createFromDate(1900, 1, 1);
        // Agregar los días del número serial menos el desfase
        return $baseDate->addDays($serialNumber - 2)->format('Y-m-d');
    }
}