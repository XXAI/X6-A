<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;

use JWTAuth;

use App\Http\Requests;
use App\Models\DictamenArchivo, App\Models\Usuario;

use Illuminate\Support\Facades\Input;
use \Validator,\Hash, \Response, DB;

class RegistroDictamenArchivoController extends Controller
{
    function destroy(Request $request, $id){
        try {
        	
            $registro = DictamenArchivo::find($id);

            if($registro)
            {
                $dictamen = $registro->id_dictamen;
                $tipo_seguimiento = $registro->id_tipo_seguimiento;
                $registro->delete();
                $total_registros = DictamenArchivo::where("id_dictamen", $dictamen)->where("id_tipo_seguimiento", $tipo_seguimiento)->get();
                
                return Response::json(['data'=>$total_registros],200);
            }else
            {
                return Response::json(['error'=>"No tiene privilegios para eliminar este usuario"],500);
            }
        } catch (Exception $e) {
           return Response::json(['error' => $e->getMessage()], HttpResponse::HTTP_CONFLICT);
        }

    }
}
