<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Terreno;
use App\Models\Comunidad;
use App\Models\TipoMejora;
use App\Models\Provincia;
use App\Models\Distrito;
use App\Models\Corregimiento;
use Illuminate\Support\Facades\Storage;

class TerrenoController extends Controller
{
    public function index(Request $request){
        $query = Terreno::with(['comunidad.corregimiento.distrito.provincia', 'tipoMejora']);
        
        if ($request->filled('tituloFinca')) {
            $query->where('tituloFinca', 'like', '%' . $request->tituloFinca . '%');
        }
    
        if ($request->filled('codigoUbicacion')) {
            $query->whereHas('comunidad.corregimiento', function($q) use ($request){
                $q->where('codigoUbicacion', 'like', '%' . $request->codigoUbicacion . '%');
            });
        }
    
        if ($request->filled('areaMin')) {
            $query->where('areaTerreno', '>=', $request->areaMin);
        }
    
        if ($request->filled('areaMax')) {
            $query->where('areaTerreno', '<=', $request->areaMax);
        }
    
        if ($request->filled('valorTerrenoMin')) {
            $query->where('valorTerreno', '>=', $request->valorTerrenoMin);
        }
    
        if ($request->filled('valorTerrenoMax')) {
            $query->where('valorTerreno', '<=', $request->valorTerrenoMax);
        }
    
        if ($request->filled('fechaInicio')) {
            $query->where('fechaInscripcion', '>=', $request->fechaInicio);
        }
    
        if ($request->filled('fechaFin')) {
            $query->where('fechaInscripcion', '<=', $request->fechaFin);
        }
    
        if ($request->filled('idTipoMejora')) {
            $query->where('idTipoMejora', $request->idTipoMejora);
        }
    
        if ($request->filled('idComunidad')) {
            $query->where('idComunidad', $request->idComunidad);
        }

        if ($request->filled('idProvincia')) {
            $query->whereHas('comunidad.corregimiento.distrito.provincia', function ($q) use ($request) {
                $q->where('id', $request->idProvincia);
            });
        }
        
        if ($request->filled('idDistrito')) {
            $query->whereHas('comunidad.corregimiento.distrito', function ($q) use ($request) {
                $q->where('id', $request->idDistrito);
            });
        }
        
        if ($request->filled('idCorregimiento')) {
            $query->whereHas('comunidad.corregimiento', function ($q) use ($request) {
                $q->where('id', $request->idCorregimiento);
            });
        }
    
        //$terrenos = $query->orderBy('created_at', 'desc')->get();
        $terrenos = $query->get();
        //TO HERE

        $comunidades = Comunidad::all();
        $tiposMejora = TipoMejora::all();
        $provincias = Provincia::all();
        return view('terrenos.index', compact('terrenos','comunidades','tiposMejora','provincias'));
    }

    public function store(Request $request){
        $data = $request->validate([
            'fechaInscripcion' => 'required|date',
            'tituloFinca' => 'required|string',
            'areaTerreno' => 'required|numeric',
            'valorTerreno' => 'required|numeric',
            'valorMejora' => 'required|numeric',
            'idTipoMejora' => 'required|exists:tipomejora,id',
            'idComunidad' => 'required|exists:comunidades,id',
            'zona' => 'nullable|string',
            'lote' => 'nullable|string',
            'planoLote' => 'nullable|file|mimes:pdf,png,jpg,jpeg|max:2048',
        ]);

        if ($request->hasFile('planoLote')) {
            //$data['planoLote'] = $request->file('planoLote')->store('planoLotes', 'public');
            $data['planoLote'] = $request->file('planoLote')->store('planos', 'public');
        }
        else{
            $data['planoLote'] = null;
        }

        //Terreno::create($data);
        //return redirect()->back()->with('success', 'Terreno registrado correctamente.');
        Terreno::create($data);

        return redirect()->route('terrenos.index')->with('success', 'Terreno creado con éxito.');
    }

    public function update(Request $request, Terreno $terreno)
    {
        //echo($terreno->id);
        $data = $request->validate([
            'fechaInscripcion' => 'required|date',
            'tituloFinca' => 'required|string',
            'areaTerreno' => 'required|numeric',
            'valorTerreno' => 'required|numeric',
            'valorMejora' => 'required|numeric',
            'idTipoMejora' => 'required|exists:tipomejora,id',
            'idComunidad' => 'required|exists:comunidades,id',
            'zona' => 'nullable|string',
            'lote' => 'nullable|string',
            'planoLote' => 'nullable|file|mimes:pdf,png,jpg,jpeg|max:2048',
        ]);

        if ($request->hasFile('planoLote')) {
            // optionally delete the old file
            if ($terreno->planoLote) Storage::disk('public')->delete($terreno->planoLote);
            $data['planoLote'] = $request->file('planoLote')->store('planoLotes', 'public');
        }

        $terreno->update($data);
        return redirect()->back()->with('success', 'Terreno actualizado.');
    }

    public function destroy(Terreno $terreno)
    {
        if ($terreno->planoLote) Storage::disk('public')->delete($terreno->planoLote);
        $terreno->delete();
        return redirect()->back()->with('success', 'Terreno eliminado.');
    }

    public function getDistritos($idProvincia){
        return response()->json(Distrito::where('idProvincia', $idProvincia)->get());
    }

    public function getCorregimientos($idDistrito){
        return response()->json(Corregimiento::where('idDistrito', $idDistrito)->get());
    }

    public function getComunidades($idCorregimiento){
        return response()->json(Comunidad::where('idCorregimiento', $idCorregimiento)->get());
    }

    public function comunidadInfo($idComunidad){
        $comunidad = Comunidad::with('corregimiento.distrito.provincia')->findOrFail($idComunidad);

        return response()->json([
            'provincia_id' => $comunidad->corregimiento->distrito->provincia->id,
            'distrito_id' => $comunidad->corregimiento->distrito->id,
            'corregimiento_id' => $comunidad->corregimiento->id,
            'comunidad_id' => $comunidad->id,
        ]);
    }

}
