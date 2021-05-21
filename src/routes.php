<?php

Route::group(['middleware' => ['web', 'auth']], function () {
    Route::get('/', 'App\Http\Controllers\AppController@home');
    Route::get('/home', 'App\Http\Controllers\AppController@home');
    // APPCONTROLLER
    Route::get('select', 'Eideos\Framework\Controllers\FmwController@select');
    Route::get('autocomplete', 'Eideos\Framework\Controllers\FmwController@autocomplete');
    Route::get('get_model_data', 'Eideos\Framework\Controllers\FmwController@get_model_data');
    Route::post('set_menu_mode/{mode}', 'Eideos\Framework\Controllers\FmwController@set_menu_mode');
    Route::get('ajax_tree_parents_to_root', 'Eideos\Framework\Controllers\FmwController@tree_parents_to_root');
    Route::get('ajax_tree_element_description', 'Eideos\Framework\Controllers\FmwController@tree_element_description');
    // BLOQUEOS
    Route::delete('blocks/ajax_free/{model}/{model_id}', 'Eideos\Framework\Controllers\BlockController@free');
    Route::get('blocks/ajax_check_status/{model}/{model_id}', 'Eideos\Framework\Controllers\BlockController@check');
    // DATOS PERSONALES
    Route::get('user_personal_data/edit', 'Eideos\Framework\Controllers\UserController@edit_personal_data');
    Route::patch('user_personal_data/update', 'Eideos\Framework\Controllers\UserController@update_personal_data');
    Route::patch('users/{id}', 'Eideos\Framework\Controllers\UserController@update');
    // FILES
    Route::get('files/download/{table}/{id}', 'Eideos\Framework\Controllers\FileController@download')->name('files.download');
    Route::get('files/download_file/{file}', 'Eideos\Framework\Controllers\FileController@download_file')->name('files.downloadfile');
    Route::get('files/display_file/{file}', 'Eideos\Framework\Controllers\FileController@display_file')->name('files.displayfile');
    Route::get('files/image/{file}/{thumbnail?}/{relativePath?}', 'Eideos\Framework\Controllers\FileController@image')->name('files.displayfile');
    Route::get('files/display/{table}/{id}', 'Eideos\Framework\Controllers\FileController@display')->name('files.display');
    Route::post('files/delete', 'Eideos\Framework\Controllers\FileController@destroy')->name('files.delete');
});

Route::group(['middleware' => ['web', 'auth', 'acl']], function () {
    // RESOURCES
    Route::resource('rights', 'Eideos\Framework\Controllers\RightController');
    Route::resource('audits', 'Eideos\Framework\Controllers\AuditController');
    Route::resource('blocks', 'Eideos\Framework\Controllers\BlockController');
    Route::resource('roles', 'Eideos\Framework\Controllers\RoleController');
    Route::resource('users', 'Eideos\Framework\Controllers\UserController');
    Route::resource('buttons', 'Eideos\Framework\Controllers\ButtonController');
    Route::resource('notifications', 'Eideos\Framework\Controllers\NotificationController');
    // EXPORTS
    Route::get('users/export/{type}', 'Eideos\Framework\Controllers\UserController@export')->name('users.export');
    Route::get('blocks/export/{type}', 'Eideos\Framework\Controllers\BlockController@export')->name('blocks.export');
    Route::get('roles/export/{type}', 'Eideos\Framework\Controllers\RoleController@export')->name('roles.export');
    Route::get('rights/export/{type}', 'Eideos\Framework\Controllers\RightController@export')->name('rights.export');
    Route::get('buttons/export/{type}', 'Eideos\Framework\Controllers\ButtonController@export')->name('buttons.export');
    Route::get('audits/export/{type}', 'Eideos\Framework\Controllers\AuditController@export')->name('audits.export');
});
