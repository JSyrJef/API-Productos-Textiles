<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imagenes_producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'producto_id',
        'imgen_url',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function getImagenUrlAttribute() {
        return asset('storage/' . $this->imagen_url);
    }    
}
