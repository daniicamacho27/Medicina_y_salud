<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use Illuminate\View\View;

class ArticuloController extends Controller
{
    public function index(): View
    {
        $articulos = Articulo::with(['categoria', 'estado'])
            ->whereHas('estado', fn ($q) => $q->where('nombre', 'publicado'))
            ->orderByDesc('fecha_publicacion')
            ->get();

        return view('articulos.index', compact('articulos'));
    }
}
