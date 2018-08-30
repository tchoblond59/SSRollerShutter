<?php
    Route::group(['middleware' => ['web']], function () {
        Route::post('/SSRollerShutter/open','Tchoblond59\SSRollerShutter\Controllers\SSRollerShutterController@open');
        Route::post('/SSRollerShutter/close','Tchoblond59\SSRollerShutter\Controllers\SSRollerShutterController@close');
        Route::post('/SSRollerShutter/stop','Tchoblond59\SSRollerShutter\Controllers\SSRollerShutterController@stop');
});