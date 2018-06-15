<?php

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

Route::get('/', function () {
    return view('welcome');
});


Route::resource('articles','ArticlesController');


Route::get('password/reset','Auth\ForgotPasswordController@showLinkRequestForm');


Route::get('auth/login',function (){
    $credentials = [
        'email' => 'john@example.com',
        'password' => 'password',
    ];

    if(!auth()->attempt($credentials)){
        return 'Worng Id/Password! Please try again!';
    }

    return redirect('protected');
});


Route::get('protected',['middleware'=>'auth',function(){
    dump(session()->all());

    return 'Welcome! '.auth()->user()->name;
}]);


Route::get('auth/logout',function(){
    auth()->logout();

    return 'See You Again!';
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


/*DB::listen(function ($query) {
    var_dump($query->sql);
});*/