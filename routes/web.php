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

	Route::get('admin/questions/buscar/{id}','QuestionController@buscar')->name('preguntas.buscar');
	Route::put('admin/questions/guardar/{id}','QuestionController@guardar')->name('preguntas.guardar');
	Route::put('admin/questions/actualizar/{id}','QuestionController@actualizar')->name('preguntas.actualizar');

	Route::get('admin/answers/buscar/{id}','AnswerController@buscar')->name('respuestas.buscar');
	Route::put('admin/answers/guardar/{id}','AnswerController@guardar')->name('respuestas.guardar');
	Route::put('admin/answers/actualizar/{id}','AnswerController@actualizar')->name('respuestas.actualizar');
	Route::get('admin/answers/eliminar/{id}','AnswerController@eliminar')->name('respuestas.eliminar');

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
Auth::routes();
// Socialite
Route::get( '/login/{social}', 'Auth\LoginController@getSocialRedirect' )
  ->middleware('guest');

Route::get( '/login/{social}/callback', 'Auth\LoginController@getSocialCallback' )
  ->middleware('guest');

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('admin')->group(function() {
	Route::get('/login',
	'Auth\AdminLoginController@showLoginForm')->name('admin.login');
	Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
	Route::get('logout/', 'Auth\AdminLoginController@logout')->name('admin.logout');
	//Route::get('/home', 'Admin\AdminController@index')->name('admin.dashboard');

}); 