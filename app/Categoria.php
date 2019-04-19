<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
	protected $table = 'categorias';
    protected $fillable = [
    	'nombre', 'condicion', 'descripcion'
    ];

    public function articulos(){
    	return $this->hasMany(Articulo::class);
    }
}
