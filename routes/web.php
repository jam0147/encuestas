<?php


Route::get('/', function () {
    return view('user.index');
})->name('user.index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['namespace' => 'Admin'],function(){
	Route::get('admin/home','IndexController@home')->name('admin.index');
	Route::resource('admin/admins','AdminController');
	Route::resource('admin/categories','CategoryController');
	Route::resource('admin/polls','PollsController');
	Route::resource('admin/questions','QuestionController');
	Route::resource('admin/answers','AnswerController');
	Route::resource('admin/ranges','RangeController');
	// Admin Auth Routes
	Route::get('admin/login', 'Auth\LoginController@showLoginForm')->name('admin.login');
	Route::post('admin/login', 'Auth\LoginController@login')->name('admin.login.post');
	Route::post('admin/logout', 'Auth\LoginController@logout')->name('admin.logout');
});

Route::group(['namespace' => 'User'],function(){
	Route::resource('user/encuestas','EncuestasController');
	Route::get('user/encuesta/reanudar/{id}','EncuestasController@reanudar')
		->name('encuestas.reanudar');
	Route::post('user/encuestas1','EncuestasController@individualStore')->name('encuestas.individual');
	Route::resource('user/test','TestController');
	
});


Route::post('Auth/guardar',	'Auth\ResetPasswordController@guardar')->name('reset');
Route::get('validar_link', 'Auth\ResetPasswordController@validar_link')->name('validar_link');
Route::get('validar_link/{codigo}', 'Auth\ResetPasswordController@validar_link');
Route::get('validar_link_confimacion', 'Auth\RegisterController@validar_link_confimacion')->name('validar_link_confimacion');
Route::get('validar_link_confimacion/{codigo}', 'Auth\RegisterController@validar_link_confimacion');
Route::get('validar_link/{codigo}', 'Auth\ResetPasswordController@validar_link');
Route::post('guardarNuevaContrasena', 'Auth\ResetPasswordController@guardarNuevaContrasena')->name('cambiar');

Auth::routes();
// Socialite
Route::get( '/login/{social}', 'Auth\LoginController@getSocialRedirect' )
  ->middleware('guest');

Route::get( '/login/{social}/callback', 'Auth\LoginController@getSocialCallback' )
  ->middleware('guest');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/vistamensajeRegistrado', 'Auth\RegisterController@vistamensajeRegistrado');
Route::get('/usuario_confirmado', 'Auth\usuarioconfirmadoController@index');

Route::prefix('admin')->group(function() {
	Route::get('/login',
	'Auth\AdminLoginController@showLoginForm')->name('admin.login');
	Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
	Route::get('logout/', 'Auth\AdminLoginController@logout')->name('admin.logout');
	//Route::get('/home', 'Admin\AdminController@index')->name('admin.dashboard');

}); 