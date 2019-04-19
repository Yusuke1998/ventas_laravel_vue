<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
use App\Categoria;

class CategoriasController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $buscar     = $request->buscar;
        $criterio   = $request->criterio;

        if ($buscar == '') {
            $categorias = Categoria::orderBy('id','desc')->paginate(5);
        }else{
            $categorias = Categoria::where($criterio,'like','%'.$buscar.'%')->orderBy('id','desc')->paginate(5);
        }

        return [
            'pagination'    => [
                'total'             =>  $categorias->total(),
                'current_page'      =>  $categorias->currentPage(),
                'per_page'          =>  $categorias->perPage(),
                'last_page'         =>  $categorias->lastPage(),
                'from'              =>  $categorias->firstItem(),
                'to'                =>  $categorias->lastItem(),
            ],
            'categorias'  =>  $categorias
        ];
    }

    public function select(Request $request){
        if (!$request->ajax()) return redirect('/');
        $categorias = Categoria::where('condicion','=','1')
        ->select('id','nombre')
        ->orderBy('nombre','asc')
        ->get();

        return ['categorias'=>$categorias];
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $categoria = Categoria::create($request->all());
        return Redirect(Route('categorias.index'));
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
        if (!$request->ajax()) return redirect('/');

        $categoria = Categoria::find($id)->update($request->all());
        return Redirect(Route('categorias.index'));
    }

    public function activar(Request $request, $id)
    {
        if (!$request->ajax()) return redirect('/');

        $categoria = Categoria::find($id)->update([
            'condicion' => '1'
        ]);
    }

    public function desactivar(Request $request, $id)
    {
        if (!$request->ajax()) return redirect('/');

        $categoria = Categoria::find($id)->update([
            'condicion' => '0'
        ]);
    }

    public function destroy($id)
    {
        if (!$request->ajax()) return redirect('/');

        $categoria = Categoria::find($id)->delete();
        return Redirect(Route('categorias.index'));
    }
}
