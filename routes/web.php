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

Route::post('resetpassword/1/{id}', 'UsuarioController@resetPassword')->name('usuario.reset');
Route::post('eliminarU/{id}', 'UsuarioController@destroy')->name('usuario.destroy');
Route::post('Bloqueo/{id}', 'UsuarioController@BloquearUser')->name('usuario.bloqueo');
Route::post('SuperUser/{id}', 'UsuarioController@SuperUsuario')->name('usuario.super');
Route::post('aumentarCantidad/{id}', 'UsuarioController@AumentoUsuario')->name('usuario.aumento');
Route::prefix('usuario')->group(function()
{    
    Route::post('resetpassword/{id}', 'UsuarioController@resetPassword')->name('usuario.reset1');
    Route::post('password/', 'UsuarioController@updatePassword')->name('usuario.updatepass');
    Route::any('create/{id}', 'UsuarioController@create')->name('usuario.create');
    Route::any('store/{id}', 'UsuarioController@store')->name('usuario.store');
});
Route::get('/errors/banned', function () {
    return view('errors.banned'); // Asegúrate de tener una vista llamada "errors/banned.blade.php"
})->name('errors.banned');

Route::get('/errors/deleted', function () {
    return view('errors.deleted'); // Asegúrate de tener una vista llamada "errors/banned.blade.php"
})->name('errors.deleted');
Route::get('/errors/permisos', function () {
    return view('errors.permisos'); // Asegúrate de tener una vista llamada "errors/banned.blade.php"
})->name('errors.permisos');


Route::resource('/notificaciones', 'NotificationsController');
Route::patch('notificaciones/read/{id}','NotificationsController@read');
Route::put('notificaciones/read/{id}','NotificationsController@read');
Route::post('notificaciones/deleteall','NotificationsController@deleteall');
Route::get('notificaciones/{url}/{id}','NotificationsController@redirect')->name('notifications.redirect');
//perfiles------------------------
Route::resource('perfil','Configuracion\PerfilController');
Route::resource('/perfilEstudiante','Comunidad\EstudianteController');
Route::resource('/perfilTutor','Comunidad\TutorController');
//tutor principal----------------------
Route::resource('relacion','Configuracion\TutorprincipalController');
//sucursales--------------------------
Route::resource('/sucursal','Configuracion\SucursalController');
Route::post('/sucursal/{id}','Configuracion\SucursalController@update')->name('sucursal.update');
Route::post('/sucursalE/{id}','Configuracion\SucursalController@destroy')->name('sucursal.destroy');
//aulas-------------------
Route::resource('/aula','Configuracion\AulaController');
//programa area de intervencion 
Route::resource('/programa','Configuracion\ProgramaController');
Route::post('/programa/{id}','Configuracion\ProgramaController@update')->name('programa.update');
Route::post('/programaE/{id}','Configuracion\ProgramaController@destroy')->name('programa.destroy');

Route::prefix('dev')->group(function(){
    Route::resource('modulo', 'Dev\ModuloController');
    Route::resource('submodulo', 'Dev\SubModuloController');
    Route::resource('permiso', 'Dev\PermisoController');
});


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


Route::get('/sidebar', function()
{
    return view("sidebar");
});
Route::get('/pass', function()
{
    $pass = Hash::make("Rm22");
    return dd($pass);
}); 






