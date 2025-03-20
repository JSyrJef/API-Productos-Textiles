<?php

namespace App\Http\Controllers;

use App\Models\Imagenes_producto;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImagenesProductoController extends Controller
{
    // Subir imagen
    public function store(Request $request, $producto_id)
    {
        $request->validate([
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('imagen')) {
            $imagenPath = $request->file('imagen')->store('imagenes_productos', 'public');

            $imagen = Imagenes_producto::create([
                'producto_id' => $producto_id,
                'imagen_url' => $imagenPath,
            ]);

            return response()->json(['message' => 'Imagen subida con éxito', 'imagen' => $imagen], 201);
        }

        return response()->json(['error' => 'No se pudo subir la imagen'], 400);
    }

    // Eliminar imagen
    public function destroy($id)
    {
        $imagen = Imagenes_producto::findOrFail($id);
        Storage::disk('public')->delete($imagen->imagen_url);
        $imagen->delete();

        return response()->json(['message' => 'Imagen eliminada con éxito']);
    }
}
