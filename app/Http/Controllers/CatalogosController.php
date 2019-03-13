<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use \Validator,\Hash, \Response, DB;

use App\Models\CatalogoEntidad, App\Models\CatalogoMunicipio, App\Models\CatalogoLocalidad;

class CatalogosController extends Controller
{
    public function Estados(Request $request)
    {
        $estados = CatalogoEntidad::all();
        return Response::json([ 'data' => $estados],200);
    }

    public function Municipios(Request $request)
    {
        $parametros = Input::all();
        $municipios = CatalogoMunicipio::where("idEntidad", "=", $parametros['idEntidad'])->orderBy("nombre", "asc")->get();
        return Response::json([ 'data' => $municipios],200);
    }

    public function Localidad(Request $request)
    {
        $parametros = Input::all();
        $localidades = CatalogoLocalidad::where("idEntidad", "=", $parametros['idEntidad'])->where("idMunicipio", "=", $parametros['idMunicipio'])->orderBy("nombre", "asc")->get();
        return Response::json([ 'data' => $localidades],200);
    }
}
