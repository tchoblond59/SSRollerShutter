<?php
    Route::group(['middleware' => ['web']], function () {
        Route::get('/SSRollerShutter/config/{id}', 'Tchoblond59\SSRollerShutter\Controllers\SSRollerShutterController@config');
        Route::get('/SSRollerShutter/calibrate/{id}', 'Tchoblond59\SSRollerShutter\Controllers\SSRollerShutterController@calibrate');
        Route::post('/SSRollerShutter/open','Tchoblond59\SSRollerShutter\Controllers\SSRollerShutterController@open');
        Route::post('/SSRollerShutter/close','Tchoblond59\SSRollerShutter\Controllers\SSRollerShutterController@close');
        Route::post('/SSRollerShutter/stop','Tchoblond59\SSRollerShutter\Controllers\SSRollerShutterController@stop');
        Route::post('/SSRollerShutter/percent/{id}','Tchoblond59\SSRollerShutter\Controllers\SSRollerShutterController@setPercent');
        Route::get('/SSRollerShutter/endstop/{id}','Tchoblond59\SSRollerShutter\Controllers\SSRollerShutterController@endStop');
        Route::post('/SSRollerShutter/addCommande/{id}','Tchoblond59\SSRollerShutter\Controllers\SSRollerShutterController@addCommande');
});