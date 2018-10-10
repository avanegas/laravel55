<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\Precio\GrupoPrecio;
use App\Models\Data\GrupoEquipo;
use App\Models\Data\GrupoMaterial;
use App\Models\Data\GrupoObrero;
use App\Models\Data\Equipo;
use App\Models\Data\Material;
use App\Models\Data\Obrero;
use App\Models\Data\Transporte;

use App\Models\Precio\Precio;
use App\Models\Precio\PrecioEquipo;
use App\Models\Precio\PrecioMaterial;
use App\Models\Precio\PrecioObrero;
use App\Models\Precio\PrecioTransporte;

use App\User;

class PrecioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')
            ->except(['index', 'show']);
    }

    public function index()
    {
        $precios = Precio::with(['grupo_precio'])->orderBy('name', 'asc')->get();

        return response()
            ->json([
                'precios' => $precios
            ]);
    }

    public function create()
    {
        $form = Precio::form();
        return response()
            ->json([
                'form' => $form
            ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'grupo_precio_id' => 'required|max:255',
            'name' => 'required|max:255',
            'unidad' => 'required|max:255',
            'detalle' => 'required|max:255',
            'directo' => 'required|numeric',
            'indirecto' => 'required|numeric',

            'equipos' => 'required|array|min:1',
            'equipos.*.equipo_id' => 'required|max:255',
            'equipos.*.name' => 'required|max:255',
            'equipos.*.tarifa' => 'required|numeric',
            'equipos.*.cantidad' => 'required|numeric',
            'equipos.*.rendimiento' => 'required|numeric',

            'materials' => 'required|array|min:1',
            'materials.*.material_id' => 'required|max:255',
            'materials.*.name' => 'required|max:255',
            'materials.*.unidad' => 'required|max:255',
            'materials.*.precio' => 'required|numeric',
            'materials.*.cantidad' => 'required|numeric',

            'obreros' => 'required|array|min:1',
            'obreros.*.obrero_id' => 'required|max:255',
            'obreros.*.name' => 'required|max:255',
            'obreros.*.jornalhora' => 'required|numeric',
            'obreros.*.cantidad' => 'required|numeric',
            'obreros.*.rendimiento' => 'required|numeric',

            'transportes' => 'required|array|min:1',
            'transportes.*.transporte_id' => 'required|max:255',
            'transportes.*.name' => 'required|max:255',
            'transportes.*.unidad' => 'required|max:255',
            'transportes.*.tarifa' => 'required|numeric',
            'transportes.*.cantidad' => 'required|numeric'
        ]);

        $equipos = [];
        $materials = [];
        $obreros = [];
        $transportes = [];

        foreach($request->equipos as $equipo) {
            $equipos[] = new PrecioEquipo($equipo);
        }
        foreach($request->materials as $material) {
            $materials[] = new PrecioMaterial($material);
        }
        foreach($request->obreros as $obrero) {
            $obreros[] = new PrecioObrero($obrero);
        }
        foreach($request->transportes as $transporte) {
            $transportes[] = new PrecioTransporte($transporte);
        }

        $precio = new Precio($request->only('grupo_precio_id', 'name', 'unidad', 'detalle', 'directo', 'indirecto'));

        $request->user()->precios()
            ->save($precio);

        $precio->equipos()
            ->saveMany($equipos);
        $precio->materials()
            ->saveMany($materials);
        $precio->obreros()
            ->saveMany($obreros);
        $precio->transportes()
            ->saveMany($transportes);

        return response()
            ->json([
                'saved' => true,
                'id' => $precio->id,
                'message' => 'You have successfully created precio!'
            ]);
    }

    public function show($id)
    {
        $precio = Precio::with(['user', 'grupo_precio', 'equipos', 'obreros', 'materials', 'transportes'])
            ->findOrFail($id);

        return response()
            ->json([
                'precio' => $precio
            ]);
    }

    public function edit($id, Request $request)
    {
        //$form = $request->user()->precios()
        //    ->with(['equipos' => function($query) {
        //                $query->get(['id', 'equipo_id', 'name', 'tarifa', 'cantidad', 'rendimiento', 'total']);
        //        }], ['materials' => function($query) {
        //                $query->get(['id', 'material_id', 'name', 'unidad', 'precio', 'cantidad', 'total']);
        //        }], ['obreros' => function($query) {
        //                $query->get(['id', 'obrero_id', 'name', 'jornalhora', 'cantidad', 'rendimiento', 'total']);
        //        }], ['transportes' => function($query) {
        //                $query->get(['id', 'transporte_id', 'name', 'unidad', 'tarifa', 'cantidad', 'distancia', 'total']);
        //        }])

        //    ->findOrFail($id, [
        //        'id', 'grupo_precio_id', 'name', 'unidad', 'detalle', 'directo', 'indirecto'
        //    ]);
        $form = Precio::with(['grupo_precio', 'equipos', 'obreros', 'materials', 'transportes'])
            ->findOrFail($id);

        return response()
            ->json([
                'form' => $form
            ]);
    }

    public function update($id, Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'grupo_precio_id' => 'required|max:255',
            'name' => 'required|max:255',
            'unidad' => 'required|max:255',
            'detalle' => 'required|max:255',
            'directo' => 'required|numeric',
            'indirecto' => 'required|numeric',

            'equipos' => 'required|array|min:1',
            'equipos.*.equipo_id' => 'required|max:255',
            'equipos.*.name' => 'required|max:255',
            'equipos.*.tarifa' => 'required|numeric',
            'equipos.*.cantidad' => 'required|numeric',
            'equipos.*.rendimiento' => 'required|numeric',

            'materials' => 'required|array|min:1',
            'materials.*.material_id' => 'required|max:255',
            'materials.*.name' => 'required|max:255',
            'materials.*.unidad' => 'required|max:255',
            'materials.*.precio' => 'required|numeric',
            'materials.*.cantidad' => 'required|numeric',

            'obreros' => 'required|array|min:1',
            'obreros.*.obrero_id' => 'required|max:255',
            'obreros.*.name' => 'required|max:255',
            'obreros.*.jornalhora' => 'required|numeric',
            'obreros.*.cantidad' => 'required|numeric',
            'obreros.*.rendimiento' => 'required|numeric',

            'transportes' => 'required|array|min:1',
            'transportes.*.transporte_id' => 'required|max:255',
            'transportes.*.name' => 'required|max:255',
            'transportes.*.unidad' => 'required|max:255',
            'transportes.*.tarifa' => 'required|numeric',
            'transportes.*.cantidad' => 'required|numeric'
        ]);

        $precio = $request->user()->precios()
            ->findOrFail($id);

        // ........................... equipos ...........................//
        $equipos = [];
        $equiposUpdated = [];

        foreach($request->equipos as $equipo) {
            $equipo['total'] = $equipo['cantidad'] * $equipo['tarifa'] * $equipo['rendimiento'];
            if(isset($equipo['id'])) {
                PrecioEquipo::where('precio_id', $precio->id)
                    ->where('id', $equipo['id'])
                    ->update($equipo);
                $equiposUpdated[] = $equipo['id'];
            } else {
                $equipos[] = new PrecioEquipo($equipo);
            }
        }

        $data = $request->except('equipos');
        $subTotalEquipos = collect($request->equipos)->sum('total');

        // ............................ obreros ...........................//
        $obreros = [];
        $obrerosUpdated = [];

        foreach($request->obreros as $obrero) {
            $obrero['total'] = $obrero['cantidad'] * $obrero['jornalhora'] * $obrero['rendimiento'];
            if(isset($equipo['id'])) {
                PrecioObrero::where('precio_id', $precio->id)
                    ->where('id', $obrero['id'])
                    ->update($obrero);
                $obrerosUpdated[] = $obrero['id'];
            } else {
                $obreros[] = new PrecioObrero($obrero);
            }
        }

        $data = $request->except('obreros');
        $subTotalObreros = collect($request->obreros)->sum('total');

        // ....................... resumen del precio .......................//
        $data['directo'] = $subTotalEquipos + $subTotalObreros;
        $precio->update($data);

        $precio->name = $request->name;
        $precio->unidad = $request->unidad;
        $precio->detalle = $request->detalle;
        $precio->directo = $request->directo;
        $precio->indirecto = $request->indirecto;

        $precio->save();

        // ......................... limpiar equipos .......................//
        PrecioEquipo::whereNotIn('id', $equiposUpdated)
            ->where('precio_id', $precio->id)
            ->delete();

        if(count($equipos)) {
            $precio->equipos()->saveMany($equipos);
        }
        // ......................... limpiar obreros .......................//
        PrecioObrero::whereNotIn('id', $obrerosUpdated)
            ->where('precio_id', $precio->id)
            ->delete();

        if(count($obreros)) {
            $precio->obreros()->saveMany($obreros);
        }

        return response()
            ->json([
                'saved' => true,
                'id' => $precio->id,
                'message' => 'You have successfully updated precio!'
            ]);
    }

    public function destroy($id, Request $request)
    {
        $precio = $request->user()->precios()
            ->findOrFail($id);

        PrecioEquipo::where('precio_id', $precio->id)
            ->delete();

        $precio->delete();

        return response()
            ->json([
                'deleted' => true
            ]);
    }
}
