<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ArticlesController extends Controller
{


	public function __construct () {
		$this->middleware('auth',['except' =>['index','show']]);
	}

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug = null)
    {
	    $query = $slug
		    ? \App\Tag::whereSlug($slug)->firstOrFail()->articles()
		    : new \App\Article;

	    //$articles = \App\Article::latest()->paginate(3);

	    $articles = $query->latest()->paginate(2);
        return view('articles.index',compact('articles'));
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
	    $article = $request->user()->articles()->create($request->all());


        if(! $article){
            return back()->withErrors('flash_message','Save Fail! please Try Again!')->withInput();
        }


		// Tags Sync
        $article->tags()->sync($request->input('tags'));


        event(new \App\Events\Event($article));

        return redirect(route('articles.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(\App\Article $article)
    {
        $comments = $article->comments()->with('replies')->whereNull('parent_id')->latest()->get();

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

}
