<?php

Route::get('/', ['as' => 'home', 'uses' => 'PagesController@index']);
Route::get('/login', ['as' => 'login', 'uses' => 'AuthController@login']);
Route::get('/profile/{id}', 'PagesController@profile');
Route::get('/profile', 'PagesController@my_profile');
Route::get('/faq', ['as' => 'faq', 'uses' => 'PagesController@faq']);
Route::get('/license', ['as' => 'license', 'uses' => 'PagesController@license']);
Route::get('/case/{id}', 'PagesController@case');
Route::post('/case/open', 'CaseController@open');
Route::get('/result', 'PagesController@result');
Route::get('/success', 'PagesController@success');
Route::get('/fail', 'PagesController@fail');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/logout', ['as' => 'logout', 'uses' => 'AuthController@logout']);
    Route::get('/ref', ['as' => 'ref', 'uses' => 'PagesController@ref']);
    Route::get('/pay', ['as' => 'pay', 'uses' => 'PagesController@pay']);
    Route::post('/withdraw', ['as' => 'withdraw', 'uses' => 'PagesController@withdraw']);
    Route::post('/takeItem', ['as' => 'takeItem', 'uses' => 'CaseController@takeItem']);
    Route::post('/sellItem', ['as' => 'sellItem', 'uses' => 'CaseController@sellItem']);
});

Route::group(['middleware' => 'auth', 'middleware' => 'access:admin'], function () {
	Route::get('/admin', ['as' => 'admin', 'uses' => 'AdminController@index']);
	/* Players */
	Route::get('/admin/users', ['as' => 'users', 'uses' => 'AdminController@users']);
	Route::post('/admin/user/save', ['as' => 'user.save', 'uses' => 'AdminController@user_save']);
	Route::get('/admin/user/{id}/edit', ['as' => 'user.edit', 'uses' => 'AdminController@edit_user']);
	Route::get('/admin/user/{id}/ban', ['as' => 'user.ban', 'uses' => 'AdminController@user_ban']);
	Route::get('/admin/user/{id}/unban', ['as' => 'user.unban', 'uses' => 'AdminController@user_unban']);
	/* Cases */
	Route::get('/admin/cases', ['as' => 'cases', 'uses' => 'AdminController@cases']);
	Route::get('/admin/new_case', ['as' => 'new_case', 'uses' => 'AdminController@new_case']);
	Route::get('/admin/case/{id}/edit', ['as' => 'case.edit', 'uses' => 'AdminController@case_edit']);
	Route::get('/admin/case/{id}/enable', ['as' => 'case.enable', 'uses' => 'AdminController@case_enable']);
	Route::get('/admin/case/{id}/disable', ['as' => 'case.disable', 'uses' => 'AdminController@case_disable']);
	Route::get('/admin/case/{id}/delete', ['as' => 'case.delete', 'uses' => 'AdminController@case_delete']);
	Route::get('/admin/item/{id}/add', ['as' => 'item.add', 'uses' => 'AdminController@item_add']);
	Route::get('/admin/item/{id}/edit', ['as' => 'item.edit', 'uses' => 'AdminController@item_edit']);
	Route::get('/admin/item/{id}/delete', ['as' => 'item.delete', 'uses' => 'AdminController@item_delete']);
	Route::post('/admin/item/add', ['as' => 'item.save', 'uses' => 'AdminController@item_create']);
	Route::post('/admin/item/update', ['as' => 'item.update', 'uses' => 'AdminController@item_update']);
	Route::post('/admin/case/save', ['as' => 'case.save', 'uses' => 'AdminController@add_case']);
	Route::post('/admin/case/update', ['as' => 'case.upd', 'uses' => 'AdminController@case_update']);
	/* Settings */
	Route::get('/admin/settings', ['as' => 'settings', 'uses' => 'AdminController@settings']);
	Route::post('/admin/settings/save', ['as' => 'settings.save', 'uses' => 'AdminController@settings_save']);
	/* Withdraw */
	Route::get('/admin/withdraw', ['as' => 'withdraw', 'uses' => 'AdminController@withdraw']);
	Route::get('/admin/won', ['as' => 'admin.won', 'uses' => 'AdminController@won']);
	Route::get('/admin/drop/{id}/done', ['as' => 'drop.done', 'uses' => 'AdminController@drop_done']);
	Route::get('/admin/drop/{id}/moneyback', ['as' => 'drop.moneyback', 'uses' => 'AdminController@drop_moneyback']);
});

Route::get('/test', 'PagesController@result');