@extends('layouts.app')


@section('content')


    <div class="container">
        <h1>새포럼 글 쓰기</h1>
        <hr/>

        <form action="{{route('articles.store')}}" method="post">

            {!! csrf_field() !!}

            <div class="form-group {{$errors->has('title') ? 'has-error' : ''}}">
                <label for="title">
                    title
                </label>
                <input type="text" name="title" id="title" value="{{old('title')}}" class="form-control">
                {!! $errors->first('title','<span class="for-error">:message</span>') !!}
            </div>

            <div class="form-group {{$errors->has('content') ? 'has-error' : ''}}">
                <label for="content">
                    Content
                </label>
                <textarea name="content" id="content" rows="10" class="form-control">
                    {{old('content')}}
                </textarea>
                {!! $errors->first('content','<span class="for-error">:message</span>') !!}
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>

        </form>
    </div>
    @stop
