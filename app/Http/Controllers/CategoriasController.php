<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categoria;

class CategoriasController extends Controller
{
    public function index()
    {
        $categorias = Categoria::all();
        return $categorias;
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $categoria = Categoria::create($request->all());
        return Redirect(Route('categorias.index'));
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $categoria = Categoria::find($id)->update($request->all());
        return Redirect(Route('categorias.index'));
    }

    public function activar(Request $request, $id)
    {
        $categoria = Categoria::find($id)->update([
            'condicion' => '1'
        ]);
    }

    public function desactivar(Request $request, $id)
    {
        $categoria = Categoria::find($id)->update([
            'condicion' => '0'
        ]);
    }

    public function destroy($id)
    {
        $categoria = Categoria::find($id)->delete();
        return Redirect(Route('categorias.index'));
    }
}
