<?php

namespace App\Http\Controllers\Data;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Data\Material;

class MaterialController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')
            ->except(['index', 'show']);
    }

    public function index()
    {
        $materials = Material::with(['grupo_material'])->orderBy('name', 'asc')->get();

        return response()
            ->json(['materials' => $materials]);
    }

    public function create()
    {
        $form = Material::form();
        return response()
            ->json(['form' => $form]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'grupo_material_id' => 'required',
            'name' => 'required|max:255',
            'unidad' => 'required|max:255',
            'precio' => 'required|numeric'
        ]);

        $material = new Material($request->only('grupo_material_id', 'name', 'unidad', 'precio'));
        $material->save();

        return response()
            ->json([
                'saved' => true,
                'id' => $material->id,
                'message' => 'Ha ingresado correctamente un material!'
            ]);
    }

    public function show($id)
    {
        $material = Material::with(['grupo_material'])
            ->findOrFail($id);
        
        return response()
            ->json(['material' => $material]);
    }

    public function edit($id, Request $request)
    {
        $form = Material::with(['grupo_material' ])
            ->findOrFail($id);

        return response()
            ->json(['form' => $form]);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'grupo_material_id' => 'required',
            'name' => 'required|max:255',
            'unidad' => 'required|max:255',
            'precio' => 'required|numeric'
        ]);

        $material = Material::findOrFail($id)->update($request->all());

        return response()
            ->json([
                'saved' => true,
                'form' => $material,
                'message' => 'Ha actualizado correctamente un material!'
            ]);
    }

    public function destroy($id, Request $request)
    {
        $material = Material::findOrFail($id);
        $material->delete();

        return response()
            ->json(['deleted' => true]);
    }
}
