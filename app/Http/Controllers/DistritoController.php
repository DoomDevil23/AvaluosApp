<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Distrito;
use Illuminate\Http\Request;

class DistritoController extends Controller
{
    public function index(){
        $distritos = Distrito::all();
        return response()->json($distritos);
    }
}
