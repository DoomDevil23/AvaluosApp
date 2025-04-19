<?php

namespace App\Http\Controllers;

use App\Models\Comunidad;
use App\Models\Provincia;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ComunidadController extends Controller
{
    public function index(Request $request){
        if($request->ajax()){
            $comunidades = Comunidad::all();
            return response()->json($comunidades);
        }
        $query = Comunidad::with(['corregimiento.distrito.provincia']);
        //->join('corregimientos', 'comunidades.idCorregimiento', 'corregimientos.id')
        //->join('distritos', 'corregimientos.idDistrito', 'distritos.id')
        //->join('provincias', 'distritos.idProvincia', 'provincias.id');
        
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if($request->filled('idProvincia')){
            $query->whereHas('corregimiento.distrito.provincia', function($q) use ($request){
                $q->where('id', $request->idProvincia);
            });
        }

        if($request->filled('idDistrito')){
            $query->whereHas('corregimiento.distrito', function($q) use ($request){
                $q->where('id', $request->idDistrito);
            });
        }

        if ($request->filled('idCorregimiento')) {
            $query->where('idCorregimiento', $request->idCorregimiento);
        }

        $comunidades = $query->get();
        $provincias = Provincia::all();

        
        //dd($request->idCorregimientoBuscar);
        return view('comunidades.index', compact('comunidades','provincias'));
    }
    
    public function store(Request $request){
        $request->validate([
            'name'=>'required|string|max:255',
            'idCorregimiento'=>'required|exists:corregimientos,id'
        ]);

        $comunidad = Comunidad::create([
            'name'=>$request->name,
            'idCorregimiento'=>$request->idCorregimiento
        ]);

        if($request->ajax())
            return response()->json($comunidad);

            return redirect()->route('comunidades.index')->with('success', 'Comunidad creada correctamente');
    }

    public function update(Request $request){
        $data = $request -> validate([
            'name'=>'required|string',
            'idCorregimiento'=>'required|numeric',
        ]);

        $comunidad = Comunidad::find($request->idComunidad);

        $comunidad->update($data);
        return redirect()->back()->with('success', 'Comunidad actualizada');
        /*dd($comunidad);
        Log the request data
        \Log::debug($request->all());
        \Log::debug($comunidad);
        dd($comunidad, $request->all());*/
    }

    public function destroy($id)
    {
        //dd($comunidad->id);
        $comunidad=Comunidad::findOrFail($id);
        $comunidad->delete();
        return redirect()->back()->with('success', 'Comunidad eliminada.');
    }
}
