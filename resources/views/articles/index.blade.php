@extends('layouts.app')

@section('content')
    @php $viewName = 'articles.index'; @endphp

    <div class="container">
        <h1>Forum <small>/ List </small></h1>
        <hr/>

        <div class="text-right">
            <a href="{{route('articles.create')}}" class="btn btn-primary">
                <i class="fa fa-plus-circle">Write</i>
            </a>
        </div>

        <div class="row container__article">
            <div class="col-md-3 sidebar__article">
                <aside>
                    @include('tags.partial.index')
                </aside>
            </div>

            <div class="col-md-9 list__article">
                <article>
                    @forelse($articles as $article)
                        @include('articles.partial.article', compact('article'))
                    @empty
                        <p class="text-center text-danger">
                            글이 없습니다.
                        </p>
                    @endforelse
                </article>

                @if($articles->count())
                    <div class="text-center paginator__article">
                        {!! $articles->appends(request()->except('page'))->render() !!}
                    </div>
                @endif
            </div>
        </div>
@stop