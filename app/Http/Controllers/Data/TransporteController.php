<?php

namespace App\Http\Controllers\Data;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Data\Transporte;

class TransporteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')
            ->except(['index', 'show']);
    }

    public function index(Request $request)
    {
        $transportes = Transporte::with(['zona'])->orderBy('name', 'asc')->get();

        return response()
            ->json([
                'transportes' => $transportes
            ]);
    }

    public function create()
    {
        $form = Transporte::form();
        return response()
            ->json([
                'form' => $form
            ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'zona_id' => 'required',
            'name' => 'required|max:255',
            'unidad' => 'required|max:255',
            'tipo' => 'required|max:255',
            'tarifa' => 'required|numeric'
        ]);

        $transporte = new Transporte($request->only('zona_id', 'name', 'unidad', 'tipo', 'tarifa'));
        $transporte->save();

        return response()
            ->json([
                'saved' => true,
                'id' => $transporte->id,
                'message' => 'Ha ingresado correctamente un transporte!'
            ]);
    }

    public function show($id)
    {
        $transporte = Transporte::with(['zona'])
            ->findOrFail($id);

        return response()
            ->json([
                'transporte' => $transporte
            ]);
    }

    public function edit($id, Request $request)
    {
        $form = Transporte::with(['zona'])
            ->findOrFail($id);
        return response()
            ->json([
                'form' => $form
            ]);
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'zona_id' => 'required',
            'name' => 'required|max:255',
            'unidad' => 'required|max:255',
            'tipo' => 'required|max:255',
            'tarifa' => 'required|numeric'
        ]);

        $transporte = Transporte::findOrFail($id)->update($request->all());

        return response()
            ->json([
                'saved' => true,
                'form' => $transporte,
                'message' => 'Ha actualizado correctamente un transporte!'
            ]);
    }

    public function destroy($id, Request $request)
    {
        $transporte = Transporte::findOrFail($id);
        $transporte->delete();

        return response()
            ->json([
                'deleted' => true
            ]);
    }
}