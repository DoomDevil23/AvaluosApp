<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Corregimiento;
use Illuminate\Http\Request;

class CorregimientoController extends Controller
{
    public function updateCodigoUbicacion(Request $request, $id){
        $corregimiento = Corregimiento::findOrFail($id);
        $corregimiento->codigoUbicacion = $request->input('codigoUbicacion');
        $corregimiento->save();

        return response()->json(['message' => 'C&oacute;digo de ubicaci&oacute;n actualizado']);
    }
}
