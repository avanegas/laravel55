<?php

namespace App\Http\Controllers\Data;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Data\Obrero;

class ObreroController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')
            ->except(['index', 'show']);
    }

    public function index()
    {
        $obreros = Obrero::with(['grupo_obrero'])->orderBy('name', 'asc')->get();

        return response()
            ->json([
                'obreros' => $obreros
            ]);
    }

    public function create()
    {
        $form = Obrero::form();
        return response()
            ->json([
                'form' => $form
            ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'grupo_obrero_id' => 'required',
            'name' => 'required|max:255',
            'jornalhora' => 'required|numeric',
            'factor' => 'required|numeric'
        ]);

        $obrero = new Obrero($request->only('grupo_obrero_id', 'name', 'jornalhora', 'factor'));
        $obrero->save();

        return response()
            ->json([
                'saved' => true,
                'id' => $obrero->id,
                'message' => 'Ha ingresado correctamente un obrero!'
            ]);
    }

    public function show($id)
    {
        $obrero = Obrero::with(['grupo_obrero'])
            ->findOrFail($id);

        return response()
            ->json([
                'obrero' => $obrero
            ]);
    }

    public function edit($id, Request $request)
    {
        $form = Obrero::with(['grupo_obrero'])
            ->findOrFail($id);
        return response()
            ->json([
                'form' => $form
            ]);
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'grupo_obrero_id' => 'required',
            'name' => 'required|max:255',
            'jornalhora' => 'required|numeric',
            'factor' => 'required|numeric'
        ]);

        $obrero = Obrero::findOrFail($id)->update($request->all());

        return response()
            ->json([
                'saved' => true,
                'form' => $obrero,
                'message' => 'Ha actualizado correctamente un obrero!'
            ]);
    }

    public function destroy($id, Request $request)
    {
        $obrero=Obrero::findOrFail($id);
        $obrero->delete();

        return response()
            ->json([
                'deleted' => true
            ]);
    }
}
