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

Route::get('/', [
    'as' => 'root',
    'uses' => 'WelcomeController@index',
]);
Route::get('/home', [
    'as' => 'home',
    'uses' => 'HomeController@index',
]);
Route::resource('articles', 'ArticlesController');


/*******************************************
 *
 * @description Markdown Editor Example
 *******************************************/
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

/*******************************************
 *
 * @description Markdown Viewer fo .md files
 *******************************************/
Route::get('docs/{file?}',function($file = null){

    $text = (new App\Documentation)->get($file);

    return App(ParsedownExtra::class)->text($text);
});


/* Markdown Viewer */
Route::get('docs/{file?}', 'DocsController@show');
Route::get('docs/images/{image}', 'DocsController@image')
    ->where('image', '[\pL-\pN\._-]+-img-[0-9]{2}.png');


/*******************************************
 *
 * @description Send Mail System in Laravel Example
 *******************************************/

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


/*******************************************
 *
 * @description User Register
 *******************************************/

Route::get('auth/register',[
   'as'   =>'users.create',
   'uses' =>'UsersController@create'
]);

Route::post('auth/register',[
   'as'   => 'users.store',
   'uses' => 'UsersController@store'
]);

Route::get('auth/confirm/{code}',[
    'as'   => 'users.confirm',
    'uses' => 'UsersController@confirm'
])->where('code','[\pL-\pN]{60}');

/*******************************************
 *
 * @description User Auth
 *******************************************/

Route::get('auth/login',[
    'as'   => 'sessions.create',
    'uses' => 'SessionsController@create'
]);

Route::post('auth/login',[
   'as'    => 'sessions.store',
   'uses'  => 'SessionsController@store',
]);

Route::get('auth/logout',[
    'as'   => 'sessions.destroy',
    'uses' => 'SessionsController@destroy'
]);

/*******************************************
 *
 * @description User PW Reset
 *******************************************/

Route::get('auth/remind',[
   'as'    => 'remind.create',
   'uses'  => 'PasswordsController@getRemind',
]);

Route::post('auth/remind',[
    'as'   => 'remind.store',
    'uses' => 'PasswordsController@postRemind',
]);

Route::get('auth/reset/{token}',[
    'as'   => 'reset.create',
    'uses' => 'PasswordsController@getReset'
])->where('token','[\pL-\pN]{64}');

Route::post('auth/reset',[
    'as'   => 'reset.store',
    'uses' => 'PasswordsController@postReset'
]);


/***********************************************
 *
 * @description Social Login
 ***********************************************/

Route::get('social/{provider}', [
	'as'   => 'social.login',
	'uses' => 'SocialController@execute',
]);

/***********************************************
 *
 * @description Tags Slug
 ***********************************************/

Route::get('tags/{slug}/articles',[
	'as'    =>'tags.articles.index',
	'uses'  =>'ArticlesController@index',
]);


/***********************************************
 *
 * @description File upload
 ***********************************************/

Route::resource('attachments',
	'AttachmentsController',
	['only' =>['store','destroy']
]);


/***********************************************
 *
 * @description File upload Extra
 ***********************************************/
Route::get('attachments/{file}', 'AttachmentsController@show');


/***********************************************
 *
 * @description Comment
 ***********************************************/
Route::resource('comments','CommentsController',['only' =>['update','destroy']]);
Route::resource('articles.comments','CommentsController',['only' =>'store']);

/***********************************************
 *
 * @description Vote
 ***********************************************/
Route::post('comments/{comment}/votes',[
	'as'    =>'comments.vote',
	'uses'  =>'CommentsController@vote',
	]);