<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArticlesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $articles = \App\Article::latest()->paginate(3);



        return view('articles.index',compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $rules = [
            'title' => ['required'],
            'content'=>['required','min:10'],
        ];

        $message =[
            'title.required' => 'Title must be Required (필수사항)',
            'content.required'=>'Content must be Required(필수사항)',
            'content.min'=>'Content will be more than 10 Characters'
        ];

        $validator = \Validator::make($request->all(), $rules, $message);

        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }

        $article = \App\User::find(1)->articles()->create($request->all());

        if(! $article){
            return back()->withErrors('flash_message','Save Fail! please Try Again!')->withInput();
        }

        return redirect(route('articles.index'))->with('flash_message','Success Save!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
