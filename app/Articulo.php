<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    protected $table = 'articulos';
    public $primaryKey = 'categoria_id';
    protected $fillable = [
    	'nombre', 'condicion', 'descripcion', 'categoria_id', 'codigo', 'precio', 'stock',
    ];

    public function categoria(){
    	return $this->belongsTo(Categoria::class);
    }
}
