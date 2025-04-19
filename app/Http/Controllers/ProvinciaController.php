<?php

namespace App\Http\Controllers;

use App\Models\Provincia;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProvinciaController extends Controller
{
    public function index(){
        $provincias = Provincia::all();
        return response()->json($provincias);
    }
}
