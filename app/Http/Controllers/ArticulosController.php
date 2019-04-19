<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Articulo;

class ArticulosController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $buscar     = $request->buscar;
        $criterio   = $request->criterio;

        if ($buscar == '') {
            $articulos = Articulo::join('categorias','articulos.categoria_id','=','categorias.id')
            ->select('articulos.id','articulos.categoria_id','articulos.codigo','articulos.nombre','categorias.nombre as nombre_categoria','articulos.precio_venta','articulos.stock','articulos.descripcion','articulos.condicion')
            ->orderBy('id','desc')->paginate(5);
        }else{
            $articulos = Articulo::join('categorias','articulos.categoria_id','=','categorias.id')
            ->select('articulos.id','articulos.categoria_id','articulos.codigo','articulos.nombre','categorias.nombre as nombre_categoria','articulos.precio_venta','articulos.stock','articulos.descripcion','articulos.condicion')
            ->where('articulos.'.$criterio,'like','%'.$buscar.'%')
            ->orderBy('articulos.id','desc')->paginate(5);
        }

        return [
            'pagination'    => [
                'total'             =>  $articulos->total(),
                'current_page'      =>  $articulos->currentPage(),
                'per_page'          =>  $articulos->perPage(),
                'last_page'         =>  $articulos->lastPage(),
                'from'              =>  $articulos->firstItem(),
                'to'                =>  $articulos->lastItem(),
            ],
            'articulos'  =>  $articulos
        ];
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $articulo = Articulo::create($request->all());
        return Redirect(Route('articulos.index'));
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
        if (!$request->ajax()) return redirect('/');

        $articulo = Articulo::find($id)->update($request->all());
        return Redirect(Route('articulos.index'));
    }

    public function activar(Request $request, $id)
    {
        if (!$request->ajax()) return redirect('/');

        $articulo = Articulo::find($id)->update([
            'condicion' => '1'
        ]);
    }

    public function desactivar(Request $request, $id)
    {
        if (!$request->ajax()) return redirect('/');

        $articulo = Articulo::find($id)->update([
            'condicion' => '0'
        ]);
    }

    public function destroy($id)
    {
        if (!$request->ajax()) return redirect('/');

        $articulo = Articulo::find($id)->delete();
        return Redirect(Route('articulos.index'));
    }
}
