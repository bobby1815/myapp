<?php
/**
 * Created by PhpStorm.
 * User: dongeon
 * Date: 18. 6. 25
 * Time: 오후 1:29
 */

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\ArticlesController as ParentController;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ArticlesController extends ParentController{

	/*******************************************************************
	 * ArticlesController constructor.
	 * @description for ignore parentController's construct
	 *******************************************************************/
	public function __construct () {

		parent::__construct();
		$this->middleware = [];
		//$this->middleware ('auth.basic.once',['except'=>['index','show','tags']]);
		$this->middleware('jwt.auth',['expect'=>['index','show','tags']]);
	}


	/*******************************************************************
	 * @param LengthAwarePaginator $articles
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 *******************************************************************/
	protected function respondCollection(LengthAwarePaginator $articles){

		//return $articles->toJson(JSON_PRETTY_PRINT);
		//return (new \App\Transformers\ArticleTransformerBasic)->withPagination($articles);
		return json()->withPagination($articles, new \App\Transformers\ArticleTransformer);
	}

	/*******************************************************************
	 * @param \App\Article $article
	 * @return \Illuminate\Http\JsonResponse|void
	 *******************************************************************/
	protected function respondCreated (\App\Article $article) {
		/*return response()->json([
			['success' => 'created'],
			201,
			['Location' => '생생한_리소스의_상세보기_API_엔드포인트'],
			JSON_PRETTY_PRINT
		]);*/

		return json()->setHeaders([
			'Location'=>route('api.v1.articles.show')->created('created'),
		]);
	}


	/*******************************************************************
	 * @param \App\Article $article
	 * @param $comment
	 * @return \Illuminate\Contracts\Http\Response
	 *******************************************************************/
	public function respondInstance(\App\Article $article, $comment){

		return json()->withItem($article, new \App\Transformers\ArticleTransformer);
	}

	/*******************************************************************
	 * @param \App\Article $article
	 * @return \Illuminate\Contracts\Http\Response
	 *******************************************************************/
	public function respondUpdated(\App\Article $article){

		return json()->success('updated');
	}

	/*******************************************************************
	 * @return \App\Tag[]|\Illuminate\Database\Eloquent\Collection
	 *******************************************************************/
	public function tags(){

		//return \App\Tag::all();

		return json()->withCollection(
			\App\Tag::all(),
			new \App\Transformers\TagTransformer
		);
	}

}