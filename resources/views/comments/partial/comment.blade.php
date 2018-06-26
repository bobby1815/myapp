@php
    $voted = null;

    if($currentUser){
    $voted = $comment->votes->contains('user_id',$currentUser->id) ? 'disabled="disabled"' : null;
    }
@endphp

<div class="media item__comment {{ $isReply ? 'sub' : 'top' }}" data-id="{{$comment->id}}" id="comment_{{$comment->id}}">
    @include('users.partial.avatar',['user' => $comment->user, 'size' => 32])

    <div class="media-body">
        <h5 class="media-heading">
            <a href="{{gravatar_profile_url($comment->user->email)}}">
                {{ $comment->user->name }}
            </a>
            <small>
                {{ $comment->created_at->diffForHumans() }}
            </small>
        </h5>
    </div>

    <div class="content__comment">
        {!! markdown($comment->content)  !!}
    </div>

    <div class="action__comment">
        @if($currentUser)
            <button class="btn__vote__comment" data-vote="up" title="Like"{{$voted}}>
                <i class="fa fa-chevron-up"></i><span>{{$comment->up_count}}</span>
            </button>
            <span> | </span>
            <button class="btn__vote__comment" data-vote="down" title="Unlike"{{$voted}}>
                <i class="fa fa-chevron-down"></i><span>{{$comment->down_count}}</span>
            </button>
            •
        @endif

        @can('update',$comment)
            <button class="btn__delete__comment">DELETE</button>•
            <button class="btn__edit__comment">MODIFY</button>•
        @endcan

        @if($currentUser)
            <button class="btn__reply__comment">
                WRITE
            </button>•
        @endif


        @if($currentUser)
            @include('comments.partial.create', ['parentId' => $comment->id])
        @endif

        @can('update', $comment)
            @include('comments.partial.edit')
        @endcan

        @if($isTrashed and ! $hasChild)


        @elseif($isTrashed and $hasChild)

            <div class="text-danger content__commnet">
                It's already delete!
            </div>


        @forelse ($comment->replies as $reply)
            @include('comments.partial.comment', [
                'comment' => $reply,
                'isReply' => true,
                'hasChild'    => $comment->replies->count(),
                'isTrashed'   => $comment->trashed(),
            ])
        @empty
        @endforelse

        @else

        @endif

    </div>
</div>