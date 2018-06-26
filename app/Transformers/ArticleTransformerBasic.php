<?php
/**
 * Created by PhpStorm.
 * User: dongeon
 * Date: 18. 6. 26
 * Time: 오전 11:05
 */

namespace App\Article;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;


class ArticleTransformerBasic {

	/***************************************************************
	 * @param LengthAwarePaginator $articles
	 * @return \Illuminate\Http\JsonResponse
	 ***************************************************************/
	public function withPagination(LengthAwarePaginator $articles){

		$payload    =[
			'total'         =>(int)$articles->total(),
			'per_page'      =>(int)$articles->perPage(),
			'current_page'  =>(int)$articles->currentPage(),
			'last_page'     =>(int)$articles->lastPage(),
			'next_page_url' => $articles->nextPageUrl(),
			'prev_page_url' => $articles->previousPageUrl(),
			'data'          => array_map([$this,'transform'],$articles->items()),
		];

		return response()->json($payload, 200,[],JSON_PRETTY_PRINT);
	}

	/***************************************************************
	 * @param Aritcle $article
	 * @return \Illuminate\Http\JsonResponse
	 ***************************************************************/
	public function withItem(Aritcle $article){

		return response()->json($this->transform($article),200,[],JSON_PRETTY_PRINT);
	}



	public function transform(\App\Article $article){

		return [
			'id'            =>(int)$article->id,
			'title'         =>$article->title,
			'content'       =>$article->content,
			'content_html'  =>markdown($article->content),
			'author'        =>[
				'name'      =>$article->user->name,
				'email'     =>$article->user->email,
				'avatar'    =>'http:' . gravatar_profile_url($article->user->email),
			],
			'tags'          => $article->tags->pluck('slug'),
			'view_count'    =>(int)$article->view_count,
			'created'       =>$article->created_at->toIso8601String(),
			'attachments'   =>(int)$article->attachments()->count(),
			'links'         =>[
				[
					'rel'   =>'self',
					'href'  => route('api.v1.articles.show',$article->id),
				],
				[
					'rel'   =>'api.v1.articles.attachments.index',
					'href'  =>route('api.v1.articles.attachments.index',$article->id),
				],
				[
					'rel'   =>'api.v1.articles.comments.index',
					'href'  =>route('api.v1.articles.comments.index',$article->id),
				],
			],
		];
	}
}