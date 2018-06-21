@php

$size = isset($size) ? $size : 48;

@endphp



@if(isset($user) and $user)
    <!--
    <b>{{$user->email}}</b>
    <p style="color: blue">{{gravatar_profile_url($user->email)}}</p>
    <p style="color: red">{{gravatar_url($user->email)}}</p>
    -->
    <a href="{{gravatar_profile_url($user->email)}}" class="pull-left">
        <img src="{{gravatar_url($user->email,$size)}}" class="media-object img-thumbnail" alt="{{$user->name}}">
    </a>
    @else
    <a href="{{gravatar_profile_url('unknown@example.com')}}" class="pull-left">
        <img src="{{gravatar_url('unknown@example.com',$size)}}" class="media-object img-thumbnail" alt="Unknown User">
    </a>
@endif
