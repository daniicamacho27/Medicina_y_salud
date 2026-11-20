<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoArticulo extends Model
{
    protected $table = 'estados_articulo';
    protected $primaryKey = 'id_estado';
    public $timestamps = false;
}
