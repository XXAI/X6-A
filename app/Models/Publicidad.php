<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class Publicidad extends BaseModel
{
    use SoftDeletes;
    
    protected $generarID = false;
    protected $guardarIDServidor = false;
    protected $guardarIDUsuario = true;
    public $incrementing = true;

    
    protected $table = 'registro_publicidad';  
    protected $fillable = ["no", "no_informe_verificacion", "id_medio_utilizado", "usuario_responsable", "id_dictamen", "id_medida_seguridad", "id_resolucion_administrativa", "id_sancion_administrativa", "fecha_emision", "usuario_id"];
}
