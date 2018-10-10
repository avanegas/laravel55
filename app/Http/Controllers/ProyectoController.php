<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Proyecto\ProyectoRubro;
use App\Models\Proyecto\Proyecto;

class ProyectoController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth:api')
    		->except(['index', 'show']);
    }

    public function index()
    {
    	$results = Proyecto::with(['user'])->orderBy('created_at', 'desc')
            ->paginate(10);

    	return response()
    		->json(['results' => $results]);
    }

    public function create()
    {
        $form = Proyecto::form();
        //dd($form);
        return response()
    		->json(['form' => $form]);
    }

    public function store(Request $request)
    {
    	$request->validate([
    		'name' => 'required|max:255',
    		'contratante' => 'required|max:255',
    		'ubicacion' => 'required|max:255',
    		'oferente' => 'required|max:255',
    		'entrega' => 'required',
    		'referencial' => 'required',
    		'indirecto' => 'required',
    		'descuento' => 'required|min:0',
    		'distancia' => 'required|min:0',
    		'sub_total' => 'required|min:0',
            'gran_total' => 'required|min:0',
    		'formato' => 'required',
    		'precision' => 'required',    		
    		'representante' => 'required',
    		'rubros' => 'required|array|min:1',
    		'rubros.*.precio_id' => 'required|max:255',
    		'rubros.*.orden' => 'required|max:255',
    		'rubros.*.rubro' => 'required|max:255',
    		'rubros.*.unidad' => 'required|max:255',
    		'rubros.*.cantidad' => 'required|max:255',
    		'rubros.*.precio' => 'required|max:255'
    		//'rubros.*.total' => 'required|max:255'
    	]);

    	$rubros = [];

        foreach($request->rubros as $rubro) {
            $rubros[] = new ProyectoRubro($rubro);
        }

    	$proyecto = new Proyecto($request->only('name', 'contratante', 'ubicacion', 'oferente', 'entrega', 'referencial', 'indirecto', 'descuento', 'distancia', 'sub_total', 'gran_total', 'formato', 'precision', 'representante'));

    	$request->user()->proyectos()
    		->save($proyecto);

    	$proyecto->rubros()
    		->saveMany($rubros);

    	return response()
    	    ->json([
    	        'saved' => true,
    	        'id' => $proyecto->id,
                'message' => 'You have successfully created project!'
    	    ]);
    }

    public function show($id)
    {
        $proyecto = Proyecto::with(['user', 'rubros'])
            ->findOrFail($id);

        return response()
            ->json(['proyecto' => $proyecto]);
    }

    public function edit($id, Request $request)
    {
        $form = $request->user()->proyectos()
            ->with(['rubros' => function($query) {
                $query->get(['id', 'precio_id', 'orden', 'rubro', 'unidad', 'cantidad', 'precio', 'total']);
            }])
            ->findOrFail($id, [
                'id', 'name', 'contratante', 'ubicacion', 'oferente', 'entrega', 'referencial', 'indirecto', 'descuento', 'distancia', 'sub_total', 'gran_total', 'formato', 'precision', 'representante'
            ]);

        return response()
            ->json(['form' => $form]);
    }

    public function update($id, Request $request)
    {
        // dd($request->all());
        $request->validate([
    		'name' => 'required|max:255',
    		'contratante' => 'required|max:255',
    		'ubicacion' => 'required|max:255',
    		'oferente' => 'required|max:255',
    		'entrega' => 'required',
    		'referencial' => 'required',
    		'indirecto' => 'required',
    		'descuento' => 'required|min:0',
    		'distancia' => 'required|min:0',
    		'sub_total' => 'required|min:0',
            'gran_total' => 'required|min:0',
    		'formato' => 'required',
    		'precision' => 'required',    		
    		'representante' => 'required',
    		'rubros' => 'required|array|min:1',
    		'rubros.*.id' => 'integer|exists:proyecto_rubros',
    		'rubros.*.precio_id' => 'required|max:255',
    		'rubros.*.orden' => 'required|max:255',
    		'rubros.*.rubro' => 'required|max:255',
    		'rubros.*.unidad' => 'required|max:255',
    		'rubros.*.cantidad' => 'required|max:255',
    		'rubros.*.precio' => 'required|max:255'
    		//'rubros.*.total' => 'required|max:255'
        ]);

        $proyecto = $request->user()->proyectos()
            ->findOrFail($id);

        $rubros = [];
        $rubrosUpdated = [];

        foreach($request->rubros as $rubro) {
            $rubro['total'] = $rubro['cantidad'] * $rubro['precio'];
            if(isset($rubro['id'])) {
                ProyectoRubro::where('proyecto_id', $proyecto->id)
                    ->where('id', $rubro['id'])
                    ->update($rubro);

                $rubrosUpdated[] = $rubro['id'];
            } else {
                $rubros[] = new ProyectoRubro($rubro);
            }
        }

        $data = $request->except('rubros');
        $data['sub_total'] = collect($request->rubros)->sum('total');
        $data['gran_total'] = $data['sub_total'] - $data['descuento'];
        $proyecto->update($data);

        $proyecto->name = $request->name;
        $proyecto->contratante = $request->contratante;
        $proyecto->ubicacion = $request->ubicacion;
        $proyecto->oferente = $request->oferente;
        $proyecto->entrega = $request->entrega;
        $proyecto->referencial = $request->referencial;
        $proyecto->indirecto = $request->indirecto;
        $proyecto->descuento = $request->descuento;
        $proyecto->distancia = $request->distancia;
        //$proyecto->sub_total = $request->sub_total;
        //$proyecto->gran_total = $request->gran_total;
        $proyecto->formato = $request->formato;
        $proyecto->precision = $request->precision;
        $proyecto->representante = $request->representante;

        $proyecto->save();

        ProyectoRubro::whereNotIn('id', $rubrosUpdated)
            ->where('proyecto_id', $proyecto->id)
            ->delete();

        if(count($rubros)) {
            $proyecto->rubros()->saveMany($rubros);
        }

        return response()
            ->json([
                'saved' => true,
                'id' => $proyecto->id,
                'message' => 'You have successfully updated proyecto!'
            ]);
    }

    public function destroy($id, Request $request)
    {
        $proyecto = $request->user()->proyectos()
                ->findOrFail($id);

        ProyectoRubro::where('proyecto_id', $proyecto->id)
                ->delete();

        $proyecto->delete();

        return response()
            ->json(['deleted' => true]);
    }
}
