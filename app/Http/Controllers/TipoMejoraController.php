<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoMejora;

class TipoMejoraController extends Controller
{
    public function index(){
        $tipomejoras = TipoMejora::all();
        return response()->json($tipomejoras);
    }
}
