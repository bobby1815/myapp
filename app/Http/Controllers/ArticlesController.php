<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArticlesController extends Controller implements Cacheable
{
	/**
	 * ArticlesController constructor.
	 */
	public function __construct(){
		parent::__construct();

		$this->middleware('auth',['except' =>['index','show']]);
	}

	public function cacheTags () {

		return 'articles';
	}

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request , $slug = null)
    {
	    $query = $slug
		    ? \App\Tag::whereSlug($slug)->firstOrFail()->articles()
		    : new \App\Article;

	    $query = $query->orderBy(
	    	$request->input('sort','created_at'),
		    $request->input('order','desc')
	    );

	    if($keyword = request()->input('q')){
	    	$raw    = 'MATCH(title,content) AGAINST(? IN BOOLEAN MODE)';
	    	$query  = $query->whereRaw($raw, [$keyword]);
	    }

	    $articles   = $query->paginate(3);

        //return view('articles.index',compact('articles'));
	    return $this->respondCollection($articles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $article = new \App\Article;

        return view('articles.create', compact('article'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(\App\Http\Requests\ArticlesRequest $request)
    {

	    $payload = array_merge($request->all(), [
		    'notification' => $request->has('notification'),
	    ]);

	    //$article = $request->user()->articles()->create($payload);
	    $article = \App\User::find(1)->articles()->create($payload);

        if(! $article){
            return back()->withErrors('flash_message','Save Fail! please Try Again!')->withInput();
        }


		// Tags Sync
        $article->tags()->sync($request->input('tags'));


        event(new \App\Events\Event($article));
        event(new \App\Events\ModelChanged(['articles']));

        //return redirect(route('articles.index'));
	    return $this->respondCreated($article);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(\App\Article $article){

    	$cacheKey       = cache('articles.index');

    	$article->view_count +=1;
    	$article->save();
	    $comments = $article->comments()
		    ->with('replies')
		    ->withTrashed()
		    ->whereNull('parent_id')
		    ->latest()->get();

        return view('articles.show',compact('article','comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(\App\Article $article)
    {
    	$this->authorize('update',$article);

        return view('articles.edit',compact('article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(\App\Http\Requests\ArticlesRequest $request,\App\Article $article)
    {
    	$this->authorize('delete',$article);
        $article->update($request->all());
	    $article->tags()->sync($request->input('tags'));
        flash()->success('Success Modified!!');

        return redirect(route('articles.show',$article->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
	public function destroy(\App\Article $article)
	{
		$this->authorize('delete', $article);
		$article->delete();
		return response()->json([], 204);
	}


	protected function respondCollection(\Illuminate\Contracts\Pagination\LengthAwarePaginator $articles){

		return view('articles.index',compact('articles'));
	}

	protected function respondCreated(\App\Article $article){

		flash()->success(trans('forum.articles.success_writing'));
	}
}
