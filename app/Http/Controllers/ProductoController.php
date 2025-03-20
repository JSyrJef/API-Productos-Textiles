<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index() {
        return Producto::with('categoria')->get();
    }

    public function store(Request $request) {
        $request->validate([
            'nombre' => 'required|string',
            'descripcion' => 'required|string',
            'categoria_id' => 'required|exists:categorias,id'
        ]);

        return Producto::create($request->all());
    }

    public function show(Producto $producto) {
        return $producto->load(['categoria', 'imagenes'])->toArray();
    }    

    public function update(Request $request, Producto $producto) {
        $producto->update($request->all());
        return $producto;
    }

    public function destroy(Producto $producto) {
        $producto->delete();
        return response()->json(['message' => 'Producto eliminado']);
    }
}
