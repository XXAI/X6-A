<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;

use App\Http\Requests;
use App\Models\Jurisdiccion;


use Illuminate\Support\Facades\Input;
use \Validator,\Hash, \Response;

class JurisdiccionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $jurisdiccion = Jurisdiccion::All();
        return Response::json([ 'data' => $jurisdiccion ],200);
    }
}
