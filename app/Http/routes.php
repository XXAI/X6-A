<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('obtener-token',    'AutenticacionController@autenticar');
Route::post('refresh-token',    'AutenticacionController@refreshToken');
Route::get('check-token',       'AutenticacionController@verificar');

Route::get('catalogo-estados',     'CatalogosController@Estados');
Route::get('catalogo-municipio',   'CatalogosController@Municipios');
Route::get('catalogo-localidad',   'CatalogosController@Localidad');

Route::resource('denuncia', 'DenunciaController',    ['only' => [ 'show', 'store']]);


Route::group(['middleware' => 'jwt'], function () {
    Route::resource('usuarios', 'UsuarioController',    ['only' => ['index', 'show', 'store','update','destroy']]);
    Route::put('editar-perfil/{id}',                    'EditarPerfilController@editar');
    Route::resource('roles', 'RolController',           ['only' => ['index', 'show', 'store','update','destroy']]);
    Route::resource('permisos', 'PermisoController',    ['only' => ['index', 'show', 'store','update','destroy']]);
    
    Route::resource('seguimiento-denuncia', 'SeguimientoDenunciaController',    ['only' => [ 'index', 'show', 'store','update','destroy']]);

    Route::resource('unidades-medicas', 'UnidadesMedicasController',    ['only' => ['index']]);

    Route::resource('jurisdiccion', 'JurisdiccionController',    ['only' => ['index', 'show', 'store','update','destroy']]);
    //Route::resource('muestra_tema', 'MuestraTemaController',    ['only' => ['index', 'show', 'store','update','destroy']]);
    Route::resource('programacion', 'ProgramacionTemaController',    ['only' => ['index', 'show', 'store','update','destroy']]);
    Route::resource('modulo-capacitacion', 'CapacitacionController',    ['only' => ['index', 'show', 'store','update','destroy']]);
    Route::resource('modulo-muestra', 'MuestraController',    ['only' => ['index', 'show', 'store','update','destroy']]);
    Route::resource('modulo-dictamen', 'DictamenController',    ['only' => ['index', 'show', 'store','update','destroy']]);
    Route::resource('modulo-verificacion', 'VerificacionController',    ['only' => ['index', 'show', 'store','update','destroy']]);
    Route::resource('modulo-reaccion', 'ReaccionController',    ['only' => ['index', 'show', 'store','update','destroy']]);
    Route::resource('modulo-determinacion', 'DeterminacionController',    ['only' => ['index', 'show', 'store','update','destroy']]);

    Route::resource('registro-verificacion', 'RegistrosVerificacionController',    ['only' => ['index', 'show', 'store','update','destroy']]);
    Route::post('registro-verificacion/{id}', 'RegistrosVerificacionController@update');
    Route::get('descargar-verificacion/{id}', 'RegistrosVerificacionController@descargar');

    Route::resource('registro-muestra', 'RegistrosMuestraController',    ['only' => ['index', 'show', 'store','update','destroy']]);
    Route::post('registro-muestra/{id}', 'RegistrosMuestraController@update');
    Route::get('descargar-muestra/{id}', 'RegistrosMuestraController@descargar');

    Route::resource('registro-determinacion', 'RegistrosDeterminacionController',    ['only' => ['index', 'show', 'store','update','destroy']]);
    Route::post('registro-determinacion/{id}', 'RegistrosDeterminacionController@update');
    Route::get('descargar-determinacion/{id}', 'RegistrosDeterminacionController@descargar');


    Route::resource('registro-capacitacion', 'RegistrosCapacitacionController',    ['only' => ['index', 'show', 'store','update','destroy']]);
    Route::post('registro-capacitacion/{id}', 'RegistrosCapacitacionController@update');
    Route::get('descargar-capacitacion/{id}', 'RegistrosCapacitacionController@descargar');

    Route::resource('registro-reaccion', 'RegistrosReaccionController',    ['only' => ['index', 'show', 'store','update','destroy']]);
    Route::post('registro-reaccion/{id}', 'RegistrosReaccionController@update');
    Route::get('descargar-reaccion/{id}', 'RegistrosReaccionController@descargar');

    Route::resource('registro-dictamen',            'RegistrosDictamenController',    ['only' => ['index', 'show', 'store','update','destroy']]);
    Route::resource('registro-dictamen-archivo',    'RegistroDictamenArchivoController',    ['only' => ['index', 'show', 'store','update','destroy']]);
    Route::post('registro-dictamen/{id}',           'RegistrosDictamenController@update');
    Route::post('registro-dictamen-archivos/{id}',  'RegistrosDictamenController@updatefile');
    Route::get('descargar-dictamen/{id}',           'RegistrosDictamenController@descargar');
    Route::get('ver-archivo/{id}',                  'RegistrosDictamenController@ver');

    Route::resource('reporte-proyecto',             'ReporteProyectoController',    ['only' => ['index']]);
    Route::resource('reporte-ambito-riesgo',         'ReporteAmbitoRiesgoController',    ['only' => ['index']]);
    Route::resource('reporte-ejecutivo',             'ReporteEjecutivoController',    ['only' => ['index']]);
    Route::resource('reporte-jurisdiccional',        'ReporteJurisdiccionalController',    ['only' => ['index']]);

    Route::get('catalogos-programacion', 'ProgramacionTemaController@catalogos');
    Route::post('validar-programacion',         'ProgramacionTemaController@validar');
    Route::post('elimina-validacion',         'ProgramacionTemaController@elimina_validacion');

    Route::resource('registro_verificacion',        'VerificacionSanitariaController',      ['only' => ['index', 'show', 'store','update','destroy']]);
    Route::resource('registro_dictamen',            'DictamenTecnicoController',            ['only' => ['index', 'show', 'store','update','destroy']]);
    Route::resource('registro_resolucion',          'ResolucionAdministrativaController',   ['only' => ['index', 'show', 'store','update','destroy']]);
    Route::resource('registro_notificacion',        'NotificacionController',               ['only' => ['index', 'show', 'store','update','destroy']]);
    Route::resource('registro_licencia',            'LicenciaSatinariaController',          ['only' => ['index', 'show', 'store','update','destroy']]);
    Route::resource('registro_aviso',               'AvisosController',                 ['only' => ['index', 'show', 'store','update','destroy']]);
    Route::resource('registro_publicidad',          'PublicidadController',                 ['only' => ['index', 'show', 'store','update','destroy']]);
    Route::get('catalogos-seguimiento', 'VerificacionSanitariaController@catalogos');
    
    //REPORTE DE SEGUIMIENTO
    Route::resource('reporte-seguimiento-verificacion',         'ReporteSeguimientoVerificacionController',    ['only' => ['index']]);
    Route::resource('reporte-seguimiento-dictamen',             'ReporteSeguimientoDictamenController',    ['only' => ['index']]);
    Route::resource('reporte-seguimiento-resolucion',           'ReporteSeguimientoResolucionController',    ['only' => ['index']]);
    Route::resource('reporte-seguimiento-notificacion',         'ReporteSeguimientoNotificacionController',    ['only' => ['index']]);
    Route::resource('reporte-seguimiento-licencia',             'ReporteSeguimientoLicenciaController',    ['only' => ['index']]);
    Route::resource('reporte-seguimiento-aviso',                'ReporteSeguimientoAvisoController',    ['only' => ['index']]);
    Route::resource('reporte-seguimiento-publicidad',           'ReporteSeguimientoPublicidadController',    ['only' => ['index']]);
    //

    Route::resource('tema', 'TemaController',    ['only' => ['index', 'show', 'store','update','destroy']]);
        
    Route::group(['prefix' => 'sync','namespace' => 'Sync'], function () {
        Route::get('manual',    'SincronizacionController@manual');        
        Route::get('auto',      'SincronizacionController@auto');
        Route::post('importar', 'SincronizacionController@importarSync');
        Route::post('confirmar', 'SincronizacionController@confirmarSync');
    });
    
});
