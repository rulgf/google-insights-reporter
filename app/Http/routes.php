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

use Illuminate\Http\Request;

Route::group(['middleware' => ['web']], function () {

    Route::auth();

    Route::get('/', 'HomeController@index');
    
    /*Route::get('/login', function () {
        return view('login');
    });*/

//Rutas Query Explorer
    Route::get('/query', 'Query\QueryController@runQuery');

//Rutas Metricas
    Route::get('/metricas', 'Metrica\MetricaController@getMetricas');

    Route::get('/metricas/{id}', 'Metrica\MetricaController@getSelectMetricas');

    Route::get('/sitemetricas/{id}', 'Metrica\MetricaController@getSiteMetricas');

    Route::get('/metrica/{id}', 'Metrica\MetricaController@getMetrica');

    Route::post('/metricas/', 'Metrica\MetricaController@createMetrica');

    Route::put('/metricas/{id}', 'Metrica\MetricaController@editMetrica');

    Route::delete('/metricas/{id}', 'Metrica\MetricaController@deleteMetrica');

//Rutas Dimensiones
    Route::get('/dimensiones', 'Dimension\DimensionController@getDimensiones');

    Route::get('/dimensiones/{id}', 'Dimension\DimensionController@getSelectDimensiones');

    Route::get('/sitedimensiones/{id}', 'Dimension\DimensionController@getSiteDimensiones');

    Route::get('/dimension/{id}', 'Dimension\DimensionController@getDimension');

    Route::post('/dimensiones/', 'Dimension\DimensionController@createDimension');

    Route::put('/dimensiones/{id}', 'Dimension\DimensionController@editDimension');

    Route::delete('/dimensiones/{id}', 'Dimension\DimensionController@deleteDimension');

//Rutas Segmentos
    Route::get('/segmentos', 'Segmento\SegmentoController@getSegmentos');

//Rutas Cuentas
    Route::get('/cuenta/{siteId}', 'Cuenta\CuentaController@getCuentaSiteId');

    Route::get('/cuentas/{id}', 'Cuenta\CuentaController@getCuenta');

    Route::get('/cuentas', 'Cuenta\CuentaController@getCuentas');

    Route::get('/allcuentas', 'Cuenta\CuentaController@getAllCuentas');

    Route::post('/cuentas', 'Cuenta\CuentaController@createCuenta');

    Route::put('/cuentas/{id}', 'Cuenta\CuentaController@editCuenta');

    Route::delete('/cuentas/{id}', 'Cuenta\CuentaController@deleteCuenta');

//Rutas Reportes
    Route::get('/reportes/{id}', 'Reporte\ReporteController@getReportes');

    Route::get('/reporte/{id}', 'Reporte\ReporteController@getReporte');

    Route::post('/reportes/', 'Reporte\ReporteController@createReporte');

    Route::put('/reportes/{id}', 'Reporte\ReporteController@editReporte');

    Route::delete('/reportes/{id}', 'Reporte\ReporteController@deleteReporte');

    Route::get('/idreporte/{cuenta_id}/{reporte_name}', 'Reporte\ReporteController@getIdReporte');

//Rutas Queries
    Route::get('/queries/{cuenta_id}/{reporte_name}', 'Reporte\InnerQueryController@getQueries');

    Route::get('/query/{id}', 'Reporte\InnerQueryController@getQuery');

    Route::post('/queries/{cuenta_id}/{reporte_name}', 'Reporte\InnerQueryController@createQuery');

    Route::put('/queries/{id}', 'Reporte\InnerQueryController@editQuery');

    Route::delete('/queries/{id}', 'Reporte\InnerQueryController@deleteQuery');

    Route::get('/innerquery', 'Reporte\InnerQueryController@execInnerQuery');

//Rutas Ejecucion Reportes

    Route::get('/execute/{reporte_id}', 'Reporte\consultReporte@executeReporte');

//Rutas Google login
    Route::get('auth/google', 'Auth\AuthController@redirectToProvider');

    Route::get('auth/google/callback', 'Auth\AuthController@handleProviderCallback');

    Route::get('/logout', 'Auth\AuthController@logout');

    Route::get('/user', 'User\UserController@getUser');

//Rutas Alertas
    Route::get('/alertas', 'Alerta\AlertaController@getAlertas');

    Route::get('/alertas/{id}', 'Alerta\AlertaController@getSiteAlertas');

    Route::get('/alerta/{id}', 'Alerta\AlertaController@getAlerta');

    Route::post('/alerta', 'Alerta\AlertaController@createAlerta');

    Route::put('/alerta/{id}', 'Alerta\AlertaController@editAlerta');

    Route::delete('/alerta/{id}', 'Alerta\AlertaController@deleteAlerta');

//Rutas Notificaciones
    Route::get('/notifications', 'Notification\NotificationController@getNotifications');

    Route::get('/unread', 'Notification\NotificationController@getUnread');

    Route::put('/notifications/{id}', 'Notification\NotificationController@readNotification');

//Rutas Reporte alternativo
    Route::get('/executealt/{reporte_id}', 'Reporte\consultReportealt@executeReporte');

//Ruta para crear PDF
    Route::post('/createpdf', 'Reporte\pdfcontroller@generatePDF');

//Rutas para obtener reportes activos
    Route::get('/reportesactives', 'Reporte\ReporteController@getActiveReports');

//Ruta para obtener cuentas activas
    Route::get('/cuentasactives', 'Cuenta\CuentaController@getActiveCuentas');
    Route::get('/cuentasinactives', 'Cuenta\CuentaController@getInactiveCuentas');

//Rutas Semaforos
    Route::get('/semaforos', 'Semaforo\SemaforoController@getSemaforos');

    Route::get('/semaforos/{id}', 'Semaforo\SemaforoController@getSiteSemaforos');

    Route::get('/semaforo/{id}', 'Semaforo\SemaforoController@getSemaforo');

    Route::post('/semaforo', 'Semaforo\SemaforoController@createSemaforo');

    Route::put('/semaforo/{id}', 'Semaforo\SemaforoController@editSemaforo');

    Route::delete('/semaforo/{id}', 'Semaforo\SemaforoController@deleteSemaforo');

    Route::get('/execsemaforos/{id}', 'Semaforo\SemaforoController@updateSemaforo');

    Route::get('/execall', 'Semaforo\SemaforoController@updateSemaforos');
    
//Rutas excel
    Route::post('/excel', 'Excel\excelController@reporte');

//Rutas Palabras
    Route::get('/palabras/{id}', 'Palabras\PalabrasController@allWords');
    
    Route::get('/topten/{id}', 'Palabras\PalabrasController@topTen');

    Route::get('/worstten/{id}', 'Palabras\PalabrasController@worstTen');

});

//Ruta del PDF para mailing
Route::get('/mailpdf/{reporte_id}', 'Mail\Mailpdfcontroller@executeReporte');

Route::get('/pruebaanalytics', 'PruebaController@getQuery');

Route::get('/excelview', 'Excel\excelController@prueba');

