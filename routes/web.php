<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('firmacorreo', function(){
    return view('firmacorreo');
});
Route::get('/', 'InicioController@index')->name('inicio');  
Route::get('/home', 'InicioController@index')->name('inicio');  

Route::resource('usuario', 'UsuarioController');
Route::prefix('usuario')->group(function()
{    
    Route::post('resetpassword/{id}', 'UsuarioController@resetPassword')->name('usuario.reset');
    Route::post('password/', 'UsuarioController@updatePassword')->name('usuario.updatepass');
    Route::any('create/{id}', 'UsuarioController@create')->name('usuario.create');
    Route::any('store/{id}', 'UsuarioController@store')->name('usuario.store');
});

Route::prefix('contabilidad')->group(function()
{   
    //Route::resource('rendiciongastos', 'Contabilidad\RendicionGastosController');
    //Route::get('rendiciongastos/create/{cont}', 'RendicionGastosController@create')->name('rendiciongastos.create');
    //Route::resource('solicitudgastos', 'SolicitudGastosController');
    //Route::resource('rendiciongastostransporte', 'RendicionGastosTransporteController');
    //Route::get('rendiciongastostransporte/create/{cont}', 'RendicionGastosTransporteController@create')->name('rendiciongastostransporte.create');

    Route::resource('rendicionfondofijo', 'RendicionFondoFijoController');
    Route::get('rendicionfondofijo/pdf/{id}', 'RendicionFondoFijoController@pdf')->name('rendicionfondofijo.pdf');
    Route::any('rendicionfondofijo/{id}/valid_edit', 'RendicionFondoFijoController@valid_edit')->name('rendicionfondofijo.valid_edit');
    Route::any('rendicionfondofijo/{id}/validar', 'RendicionFondoFijoController@validar')->name('rendicionfondofijo.validar');
    Route::any('rendicionfondofijo/{id}/denegar', 'RendicionFondoFijoController@denegar')->name('rendicionfondofijo.denegar');

    Route::resource('rendiciongastosviatico', 'RendicionGastosViaticoController');

    Route::resource('arqueocaja', 'ArqueoCajaController');
});

// Route::prefix('rrhh')->group(function()
// {   
//     Route::resource('licencia', 'Rh\LicenciaController');
//     Route::get('licencia/create/{cont}', 'Rh\LicenciaController@create')->name('licencia');

//     Route::resource('vacacion', 'Rh\VacacionController');
//     Route::get('vacacion_pdf/{id}', 'Rh\VacacionController@pdf')->name('vacacion.pdf');
// });

Route::prefix('ventas')->group(function()
{ 
    Route::resource('cotizacion', 'CotizacionController');
    Route::put('cotizacion/estado/{id}', 'CotizacionController@estado')->name('cotizacion.estado');
    Route::patch('cotizacion/estado/{id}', 'CotizacionController@estado')->name('cotizacion.estado');
    Route::put('cotizacion/upload/{id}', 'CotizacionController@upload')->name('cotizacion.upload');
    Route::patch('cotizacion/upload/{id}', 'CotizacionController@upload')->name('cotizacion.upload');
    Route::post('cotizacion/download/{id}', 'CotizacionController@download')->name('cotizacion.download');  

    Route::resource('planificacion', 'PlanificacionController');
    Route::post('planificacion/next/{id}', 'PlanificacionController@nextDay')->name('planificacion.nextDay');
    Route::post('planificacion/finalizar/', 'PlanificacionController@finalizar')->name('planificacion.finalizar');
});

Route::resource('/notificaciones', 'NotificationsController');
Route::patch('notificaciones/read/{id}','NotificationsController@read');
Route::put('notificaciones/read/{id}','NotificationsController@read');
Route::post('notificaciones/deleteall','NotificationsController@deleteall');
Route::get('notificaciones/{url}/{id}','NotificationsController@redirect')->name('notifications.redirect');


Route::resource('materialfaltante', 'MaterialFaltanteController');
Route::match(['PUT', 'PATCH'], 'materialfaltante/estado/{id}', 'MaterialFaltanteController@estado')->name('materialfaltante.estado');

Route::get('/inventariomenu', function(){
    return view('inventariosistemasmenu');
})->name('inventario.menu');


/*Route::resource('pctransfer', function(){ return true;
});*/
//Route::any('pctransfer/quitar/{id}', 'PcTransferController@quitar')->name('pctransfer.quitar');

Route::prefix('sistemas')->group(function(){
    Route::prefix('inventario')->group(function(){
        Route::any('config', 'Sistemas\SisInvController@index')->name("sis.inv.config");
        Route::any('config/store', 'Sistemas\SisInvController@store')->name("sis.inv.config.store");
        Route::post('config/destroy', 'Sistemas\SisInvController@destroy')->name("sis.inv.config.destroy");
        Route::post('config/list', 'Sistemas\SisInvController@list')->name("sis.inv.config.list");

        Route::resource('dispositivos', 'Sistemas\InventarioDispositivosController');
        Route::resource('celulares', 'Sistemas\InventarioCelularController');

        Route::resource('inventariosistemas', 'Sistemas\InventarioSistemasController');
        Route::get('inventariosistemas/create/{cont}', 'Sistemas\InventarioSistemasController@create')->name('inventariosistemas.create');
        Route::get('inventariosistemas/generar/pdf', 'Sistemas\InventarioSistemasController@pdf')->name('inventariosistemas.pdf');
        Route::get('inventariosistemas/generar/pdfqr', 'Sistemas\InventarioSistemasController@pdfqr')->name('inventariosistemas.pdf');
    });
});

Route::resource('perfil','Configuracion\PerfilController');



Route::prefix('reports')->group(function(){
    Route::resource('comprasmov','Reports\ComprasMovimientosController');
    Route::resource('compraslocmov','Reports\ComprasLocalesMovimientosController');

    Route::resource('segmentoproducto', 'Reports\SegmentoProductoController');
    Route::resource('paretoxmes', 'Reports\ParetoXMesController');

    Route::resource('stock', 'Reports\StockController');
    Route::any('stock/store/almxu', 'Reports\StockController@store_almxu')->name('stock.store_almxu');

    Route::resource('listaPrecio', 'Reports\PrecioListaController');
    Route::any('listaPrecio/store/almxu', 'Reports\StockController@store_almxu')->name('listaPrecio.store_almxu');

    Route::resource('reporteStock', 'Reports\ReporteStockController');
    Route::any('reporteStock/store/almxu', 'Reports\StockController@store_almxu')->name('reporteStock.store_almxu');
    // Route::any('listaPrecio/store/almxu', 'Reports\StockController@store_almxu')->name('stock.store_almxu');

    Route::resource('stockventa', 'Reports\StockVentaController');
    Route::any('stockventa/store/almxu', 'Reports\StockVentaController@store_almxu')->name('stockventa.store_almxu');
    Route::post('reports/stockventa','Reports\StockVentaController@historia')->name('stockventa.historia');
    Route::get('reports/stockventa/{alm_origen}/{alm_destino}','Reports\StockVentaController@show2')->name('stockventa.show2');

    Route::resource('stockminmax', 'Reports\StockMinMaxController');
    Route::any('stockminmax/store/almxu', 'Reports\StockMinMaxController@store_almxu')->name('stockminmax.store_almxu');

    Route::resource('stockcompra', 'Reports\StockCompraController');
    Route::any('stockcompra/store/almxu', 'Reports\StockCompraController@store_almxu')->name('stockcompra.store_almxu');

    Route::resource('ventasinsmayo', 'Reports\VentasInsMayoController');
    Route::resource('cuentasporcobrar', 'Reports\CuentasPorCobrarController');
    Route::resource('cuentasporcobrardetalle', 'Reports\CuentasPorCobrarDetalleController');

    Route::resource('cuentasporcobrartotal', 'Reports\CuentasPorCobrarTotalController');
    Route::resource('cuentasporcobrardetalletotal', 'Reports\CuentasPorCobrarDetalleTotalController');

    Route::resource('cuentasporpagar', 'Reports\CuentasPorPagarController');
    Route::resource('cuentasporpagardetalle', 'Reports\CuentasPorPagarDetalleController');

    Route::resource('reporteventas', 'Reports\ReporteVentasController');
    Route::resource('reporteventasdetalle', 'Reports\ReporteVentasDetalleController');

    Route::resource('resumenventastotal', 'Reports\ResumenVentasTotalController');
    Route::resource('notasremision', 'Reports\NotasRemisionController');

    Route::resource('traspasos', 'Reports\TraspasosController');
    Route::resource('traspasosdetalle', 'Reports\TraspasoDetalleController');

    Route::resource('precioscostos', 'Reports\PreciosCostosController');
    Route::resource('resumenventascobros', 'Reports\ResumenVentasCobrosController');

    Route::resource('ventamarcauser', 'Reports\VentaMarcaUserController');
    Route::any('ventamarcauser/table/general','Reports\VentaMarcaUserController@general')->name('ventamarcauser.general');   
    Route::any('ventamarcauser/table/getConfig','Reports\VentaMarcaUserController@getConfig')->name('ventamarcauser.getConfig'); 
    Route::any('ventamarcauser/table/testeo','Reports\VentaMarcaUserController@testeo')->name('ventamarcauser.testeo');   
    Route::any('ventamarcauser/get/datos','Reports\VentaMarcaUserController@getDatos')->name('ventamarcauser.getdatos');   

    Route::resource('pareto', 'Reports\ParetoController');

    Route::any('ventamarcauser/table/general_grupo','Reports\VentaMarcaUserController@general_grupo')->name('ventamarcauser.general_grupo');  
    Route::any('ventamarcauser/table/index_grupo','Reports\VentaMarcaUserController@index_grupo')->name('ventamarcauser.index_grupo');    

    Route::resource('reportevts', 'Reports\ReporteVtsController');

    Route::resource('precios', 'Reports\ReportePrecioController');

    Route::resource('difereciacosto', 'Reports\DiferenciaCostoController');
    Route::any('ventamarcauser/table/products','Reports\DiferenciaCostoController@products')->name('difereciacosto.products');  
    
    Route::resource('diferenciacostoalmacen', 'Reports\DiferenciaCostoAlmacenController');
    Route::resource('diferenciacostoalmacendetalle', 'Reports\DiferenciaCostoAlmacenDetalleController');

    Route::resource('kardexalmacen', 'Reports\KardexAlmacenController');
    Route::any('ventamarcauser/table/products3','Reports\KardexAlmacenController@products')->name('kardexalmacen.products');  

    Route::resource('kardexreport', 'Reports\KardexReportController');
    Route::any('ventamarcauser/table/products2','Reports\kardexreportController@products')->name('kardexreport.products'); 

    Route::resource('reproceso', 'Reports\ReporteReprocesoController');
});

Route::prefix('dev')->group(function(){
    Route::resource('modulo', 'Dev\ModuloController');
    Route::resource('submodulo', 'Dev\SubModuloController');
    Route::resource('permiso', 'Dev\PermisoController');
});
//eventos
Route::get('/chat', function(){
    event(new \App\Events\PublicMessage("holaaaaaaaaaaaaaa"));
    dd('Public event executed successfully');
});

/*Route::get('/private-chat', function(){
    event(new \App\Events\PrivateMessage(auth()->user()));
    dd('Private event executed successfully');
});*/

Route::get('/pdfvac', function()
{
    return view("pdf.vacaciones");
});
Auth::routes();

Route::middleware('auth')->group(function() {
    Route::get('/sessions', function () {
        $sessions = DB::table('sessions')
            ->where('user_id', auth()->id())
            ->orderBy('last_activity', 'DESC')
            ->get();
        return view('sessions', ['sessions' => $sessions]);
});
    Route::post('/delete-session', function(Request $request) {
        DB::table('sessions')
            ->where('id', $request->id)
            ->where('user_id', auth()->id())
            ->delete();
    })->name('session.delete');
});

Route::any('/test', 'TestController@index')->name('test.index ');
Route::get('/test-data', 'TestController@data')->name('test.data');

Route::get('/sidebar', function()
{
    return view("sidebar");
});
Route::get('/pass', function()
{
    //$pass = Hash::make("victorS22");
    return dd($pass);
}); 

Route::prefix('inventario')->group(function(){
    Route::resource('tomainventario', 'Inventarios\TomaInventarioController');
    Route::any('tomainventario/table/products','Inventarios\TomaInventarioController@getProd')->name('tomainventario.prod');  
    Route::any('tomainventario/table/ingresos','Inventarios\TomaInventarioController@ingresos')->name('tomainventario.ingresos');  
    Route::any('tomainventario/get/produbi','Inventarios\TomaInventarioController@get_ubi_prod')->name('tomainventario.getprodubi'); 
    Route::any('tomainventario/store/produbi','Inventarios\TomaInventarioController@store_ubi_prod')->name('tomainventario.storeprodubi');  
    Route::any('tomainventario/get/pdf', 'Inventarios\TomaInventarioController@pdf')->name('tomainventario.pdf');
    Route::any('tomainventario/get/excel', 'Inventarios\TomaInventarioController@excel')->name('tomainventario.excel');
    Route::any('tomainventario/get/paginas', 'Inventarios\TomaInventarioController@paginas')->name('tomainventario.paginas');
    
    Route::resource('tominvconfig', 'Inventarios\TomInvConfigController');
    Route::any('tominvconfig/get/tom', 'Inventarios\TomInvConfigController@getTom')->name('tominvconfig.gettom');
    Route::any('tominvconfig/get/cont', 'Inventarios\TomInvConfigController@getCont')->name('tominvconfig.getcont');
    Route::any('tominvconfig/get/sucs', 'Inventarios\TomInvConfigController@getSucs')->name('tominvconfig.getsucs');
    Route::any('tominvconfig/store/tom', 'Inventarios\TomInvConfigController@storeTom')->name('tominvconfig.storetom');
    Route::delete('tominvconfig/store/destryo_ubic', 'Inventarios\TomInvConfigController@destroy_ubic')->name('tominvconfig.destroy_ubic');

    Route::resource('tominvtom', 'Inventarios\TomInvTomController');
    Route::resource('tominvreq', 'Inventarios\TomInvReqController');
    Route::any('tominvreq/get/prods', 'Inventarios\TomInvReqController@prods')->name('tominvreq.prods');
    Route::any('tominvreq/get/pdf', 'Inventarios\TomInvReqController@pdf')->name('tominvconfig.pdf');
    
    Route::resource('invconsult', 'Inventarios\InvProdConsultController');
    Route::resource('invconsultdetalle', 'Inventarios\InvProdConsultDetalleController');

    Route::resource('tominvprodubi', 'Inventarios\TomInvProdUbiController');
    Route::any('tominvprodubi/get/prods', 'Inventarios\TomInvProdUbiController@prods')->name('tominvprodubi.prods');
    Route::any('tominvprodubi/get/modulos', 'Inventarios\TomInvProdUbiController@modulos')->name('tominvprodubi.modulos');
});
Route::resource('empleados', 'EmpleadoController');

Route::resource('equipos', 'EquipoController');

Route::resource('computadoras', ComputadoraController::class);

Route::post('/empleados', 'ComputadoraController@store')->name('computadoras.storecreate');

Route::resource('componentes', 'ComponenteController');

Route::resource('historias', 'HistoriaController')->middleware('auth');

Route::get('/equipos/create/{id_empleado}', 'EquipoController@creates')->name('equipos.creates');

// Route::post('/empleados/{id}', 'EquipoController@traspaso')->name('equipos.traspaso');

Route::post('/empleados/{id}', 'ComputadoraController@cambio')->name('computadoras.cambio');
Route::resource('permisos', 'IndexPermisosController');
Route::resource('vacaciones', 'IndexVacacionesController');
Route::resource('LV', 'IndexLVController');

Route::resource('vacacion', 'VacacionController');
Route::get('vacacion_pdf/{id}','VacacionController@generatePDF')->name('vacacion_pdf');
Route::get('vacacion/estado/{id}', 'VacacionController@estado')->name('vacacion.estado');
Route::get('vacacion_detalle/{id}', 'VacacionController@estadoForm')->name('vacacion.estadoForm');
Route::get('listadoVacacion', 'VacacionController@listado')->name('vacacion.listado');

//!-------------------caminos de reprotte cotizacion------------------------------------------
Route::resource('/CotizacionReporte', 'CotizacionReportController')->name('*','CotizacionReporte');
//Route::get('/CotizacionReporte/reportePDF','CotizacionReportController@verPDF')->name('ReportePDF.verPDF');
Route::get('/CotizacionReporte/reportePDF','Sistemas\CotizacionReportController@show')->name('CotizacionReporte.show');
Route::post('/CotizacionReporte/vistaTotal/v','CotizacionReportController@store')->name('vistaF.store');
Route::post('/CotizacionReporte/vistaTotal/v/s','CotizacionReportController@crearZ')->name('CotizacionReporte.crearZ');
//Route::get('/CotizacionReporte/vistaTotal/v/{cotizacion_report}/edit','CotizacionReportController@edit')->name('CotizacionReporte.edit');
Route::put('/CotizacionReporte/vistaTotal/v/{cotizacion_report}/update','CotizacionReportController@update')->name('CotizacionReporte.update');
Route::put('/CotizacionReporte/vistaTotal/v/{cotizacion_report}/estado', 'CotizacionReportController@estado')->name('CotizacionReporte.estado');
//Route::patch('/CotizacionReporte/vistaTotal/v/{cotizacion_report}/estado', 'CotizacionReportController@estado')->name('CotizacionReporte.estado');
Route::get('/CotizacionReporte/vistaTotal/vs','CotizacionReportController@store')->name('Cotizacion.store');
Route::get('/CotizacionReporte/vistaTotal/v/{cotizacion_report}/edit','CotizacionReportController@edit')->name('CotizacionReporte.edit');

Route::get('/CotizacionReporte/vistaTotal/bS','CotizacionReportController@buscar')->name('Cotizacion.buscar');

Route::post('/CotizacionReporte/vistaTotal/fac','CotizacionReportController@facturaConsol')->name('CotizacionReporte.facturaConsol');

Route::resource('/resumenxmes','Reports\ResumenMesVentasController');
Route::resource('/resumenxmescosto','Reports\ResumenMesCostosVentasController');

Route::resource('GeneradorCartas', 'GeneradorCartaController');
Route::get('GeneradorCartas/perfiles/{perfil}','GeneradorCartaController@vista')->name('GeneradorCartas.vista');
Route::get('GeneradorCartas/perfiles/data/pdf','GeneradorCartaController@store')->name('GeneradorCartas.store');
Route::post('GeneradorCartas/carta/date/1/pdf','GeneradorCartaController@carta')->name('GeneradorCartas.carta');

Route::resource('licencia', 'LicenciaController');
Route::get('licencia/create/{cont}', 'LicenciaController@create')->name('licencia');
Route::get('licencia/estado/{id}', 'LicenciaController@estado')->name('licencia.estado');
Route::get('licencia_detalle/{id}', 'LicenciaController@estadoForm')->name('licencia.estadoForm');
Route::get('licencia_pdf/{id}', 'LicenciaController@generatePDF')->name('licencia_pdf');
Route::get('listadoLicencia', 'LicenciaController@listado')->name('licencia.listado');

Route::resource('permisos', 'IndexPermisosController');
Route::resource('vacaciones', 'IndexVacacionesController');
Route::resource('LV', 'IndexLVController');

Route::resource('vacacion', 'VacacionController');
Route::get('vacacion_pdf/{id}', 'VacacionController@generatePDF')->name('vacacion_pdf');
Route::get('vacacion/estado/{id}', 'VacacionController@estado')->name('vacacion.estado');
Route::get('vacacion_detalle/{id}', 'VacacionController@estadoForm')->name('vacacion.estadoForm');
Route::get('listadoVacacion', 'VacacionController@listado')->name('vacacion.listado');