<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class DataImportController extends Controller
{
    public function index() {
        return view('upload.index'); 
    }
    
    public function uploadInserts(Request $request)
{
    $request->validate([
        'sql_file' => 'required|mimes:txt',
    ]);

    $file = $request->file('sql_file');
    $lines = file($file->getRealPath(), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    $inserted = 0;
    $failed = 0;
    $alreadyExists = 0;

    DB::beginTransaction();

    try {
        $combinedSql = ''; // Acumulador de la sentencia SQL

        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) {
                continue;
            }

            // Acumula la línea
            $combinedSql .= ' ' . $line;

            // Verifica si la línea termina con un punto y coma
            if (substr($line, -1) === ';') {
                // Procesa la sentencia completa
                Log::info("Procesando SQL completo: " . $combinedSql);

                // Ajuste para manejar múltiples conjuntos de valores
                if (preg_match('/INSERT INTO `(\w+)` \((.+)\) VALUES\s*(.+);/s', $combinedSql, $matches)) {
                    $table = $matches[1];
                    $columns = array_map('trim', explode(',', str_replace('`', '', $matches[2])));
                    $valuesSets = preg_split('/\),\s*\(/', trim($matches[3], '()'));

                    foreach ($valuesSets as $valuesSet) {
                        $values = array_map('trim', explode(',', str_replace(['\'', '"'], '', $valuesSet)));

                        // Verificar que el número de columnas coincida con el número de valores
                        if (count($columns) != count($values)) {
                            Log::error("Número de columnas y valores no coinciden: " . json_encode($columns) . " vs " . json_encode($values));
                            $failed++;
                            continue;
                        }

                        // Crear array de datos sin espacios innecesarios
                        $data = array_combine($columns, $values);

                        Log::info("Datos procesados para la tabla $table: ", $data);

                        // Verificar si el registro ya existe basado en todos los campos relevantes
                        $query = DB::table($table)
                            ->where(function ($query) use ($data) {
                                foreach ($data as $column => $value) {
                                    $query->where($column, $value);
                                }
                            })->first();

                        if ($query) {
                            $alreadyExists++;
                            Log::info("Registro ya existe en la tabla $table: ", $data);
                        } else {
                            $result = DB::table($table)->insert($data);

                            if ($result) {
                                $inserted++;
                                Log::info("Registro insertado en la tabla $table: ", $data);
                            } else {
                                $failed++;
                                Log::error("Error al insertar el registro en la tabla $table: ", $data);
                            }
                        }
                    }
                } else {
                    Log::warning("Línea no coincide con el patrón esperado: " . $combinedSql);
                }

                // Reinicia el acumulador después de procesar
                $combinedSql = '';
            }
        }

        DB::commit();
    } catch (\Exception $e) {
        DB::rollBack();

        if ($request->ajax()) {
            return response()->json([
                'message' => 'Ocurrió un error durante la carga de datos.',
                'error' => $e->getMessage()
            ], 500);
        } else {
            return redirect()->route('upload.index')->with('error', 'Ocurrió un error durante la carga de datos: ' . $e->getMessage());
        }
    }

    $total = $inserted + $alreadyExists + $failed;

    if ($request->ajax()) {
        return response()->json([
            'message' => 'Carga de datos completada.',
            'inserted' => $inserted,
            'already_exists' => $alreadyExists,
            'failed' => $failed,
            'total' => $total
        ]);
    } else {
        return redirect()->route('upload.index')->with('success', "Carga de datos completada. Insertados: $inserted, Ya existentes: $alreadyExists, Fallidos: $failed, Total: $total.");
    }
}

}
