<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class MuestraTema extends BaseModel
{
    use SoftDeletes;
    
    protected $generarID = false;
    protected $guardarIDServidor = false;
    //protected $guardarIDUsuario = false;
    public $incrementing = true;

    
    protected $table = 'muestra_tema';  
    protected $fillable = ["id_jurisdiccion", "id_tema_variable", "fecha_registro", "fecha_actual", "anio", "mes"];
}
