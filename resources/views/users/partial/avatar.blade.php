@php

$size = isset($size) ? $size : 48;

@endphp



@if(isset($user) and $user)
    <a href="{{gravatar_profile_url($user->email)}}" class="pull-left">
        <img src="{{gravatar_profile_url($user->email)}}" class="media-object img-thumbnail" alt="{{$user->name}}">
    </a>
    @else
    <a href="{{gravatar_profile_url('unknown@example.com')}}" class="pull-left">
        <img src="{{gravatar_profile_url('unknown@example.com')}}" class="media-object img-thumbnail" alt="Unknown User">
    </a>
ex@endif
