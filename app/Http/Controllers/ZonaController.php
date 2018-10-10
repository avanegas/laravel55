<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Zona;

class ZonaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')
            ->except(['index', 'show']);
    }

    public function index(Request $request)
    {
        $zonas = Zona::with(['user'])->orderBy('name', 'asc')->get();
        return response()

            ->json([
                'zonas' => $zonas
            ]);
    }
}
