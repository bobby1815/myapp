
<h1>
    {{ $comment->commentable->title }}
    <small>by {{ $comment->user->name }}</small>
</h1>

<hr/>

<p>
    {!! markdown($comment->content) !!}

    <small>
        {{ $comment->created_at->timezone('Asia/Seoul') }}
    </small>
</p>

<hr/>

<footer>
    This mail is from {{ config('app.url') }}. Thanks!
</footer>