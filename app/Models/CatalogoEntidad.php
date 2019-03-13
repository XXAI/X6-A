<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class CatalogoEntidad extends BaseModel
{
    use SoftDeletes;
    
    protected $generarID = false;
    protected $guardarIDServidor = false;
    protected $guardarIDUsuario = false;
    public $incrementing = true;

    
    protected $table = 'catalogo_entidad';  
    protected $fillable = ["id", "clave", "descripcion"];

    public function catalogoMunicipioPersona(){
        return $this->belongsTo('App\Models\CatalogoMunicipio', 'municipio_persona');
    }
}