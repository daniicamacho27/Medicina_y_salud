<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Articulo extends Model
{
    protected $table = 'articulos';
    protected $primaryKey = 'id_articulo';

    protected $casts = [
        'fecha_publicacion' => 'date',
    ];

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'id_categoria', 'id_categoria');
    }

    public function estado(): BelongsTo
    {
        return $this->belongsTo(EstadoArticulo::class, 'id_estado', 'id_estado');
    }
}
