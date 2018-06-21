@extends('layouts.app')


@section('content')


    <div class="container">
        <h1>Write New Forum</h1>
        <hr/>

        <form action="{{route('articles.store')}}" method="post" enctype="multipart/form-data">
            {!! csrf_field() !!}

            @include('articles.partial.form')
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
    @stop
