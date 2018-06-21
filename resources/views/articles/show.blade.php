@extends('layouts.app')

@section('content')
    @php $viewName = 'articles.show'; @endphp

    <div class="page-header">
        <h4>Forum <small> / {{$article->title}}</small></h4>
    </div>

    <article data-id="{{$article->id}}">
        @include('articles.partial.article', compact('article'))

        <p>{!! markdown($article->content) !!}</p>
    </article>

    <div class="text-center action__article">
        @can('update',$article)
        <a href="{{route('articles.edit',$article->id)}}" class="btn btn-info">
            <i class="fa fa-trash-o">Modify</i>
        </a>
        @endcan
        @can('delete',$article)
        <button id="button__delete" class="btn btn-danger button__delete">
            <i class="fa fa-trash-o">
                Delete
            </i>
        </button>
            @endcan
        <a href="{{route('articles.index')}}" class="btn btn-default">
            <i class="fa fa-list">List</i>
        </a>
    </div>
@stop

@section('script')
    <script>
        $.ajaxSetup({ headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });


        $('.button__delete').on('click', function (e) {
            var articleId = $('article').data('id');

            console.log("Check articleId ====> " , articleId);
            if (confirm('Delete Forum.')) {
                $.ajax({
                    type: 'delete',
                    url: '/articles/' + articleId,
                }).then(function () {
                    window.location.href = '/articles';
                });
            }
        });
    </script>
    @stop
