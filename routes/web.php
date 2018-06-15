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

/*Event::listen('article.created',function($article){

    var_dump('Get event. Event status will be');
    var_dump($article->toArray());
});*/


Route::get('markdown',function(){
   $text =<<<EOT
    
    # Exapmle Markdown
    
    This document written by [markdown][1]. It will display converting by HTML CODE
    
    ## no natural ordering list
    
    - first list
    - second list[^1]
    
    [1]: htpp://daringfireball.net/projects/markdown
    
    [^1]: second list_ http://google.com
EOT;

   return app(ParsedownExtra::class)->text($text);
});

Route::get('docs/{file?}',function($file = null){

    $text = (new App\Documentation)->get($file);

    return App(ParsedownExtra::class)->text($text);
});

Route::get('mail',function (){

    $article = App\Article::with('user')->find(1);

    return Mail::send(
        'emails.articles.created',
        compact('article'),
        function($message) use ($article){
            $message->from('duehddjs@gmail.com','Dongeon YEO');
            $message->to('deyeo@yongsanzip.com');
            $message->subject('Hot Issue Arrival!! -' . $article->title);
            $message->cc('bobby1815@naver.com');
            $message->attach(storage_path('sims.png'));
        }
    );
});