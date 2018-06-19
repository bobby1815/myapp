@extends('layouts.app')

@section('content')
    <form action="{{ route('sessions.store') }}" method="POST" role="form" class="form__auth">
        {!! csrf_field() !!}

        <div class="page-header">
            <h4>Login</h4>
            <p class="text-muted">
                Login with Github Account. You can use also {{config('app.name')}} Account.
            </p>
        </div>

        <div class="form-group">
            <a href="{{route('social.login',['github'])}}" class="btn btn-default btn-lg btn-block">
                <strong><i class="fa fa-github"></i>Login with Git Account</strong>
            </a>
        </div>

        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
            <input type="email" name="email" class="form-control" placeholder="이메일" value="{{ old('email') }}" autofocus/>
            {!! $errors->first('email', '<span class="form-error">:message</span>') !!}
        </div>

        <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
            <input type="password" name="password" class="form-control" placeholder="password">
            {!! $errors->first('password', '<span class="form-error">:message</span>')!!}
        </div>

        <div class="form-group">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="remember" value="{{ old('remember', 1) }}" checked>
                    Remember ID
                    <span class="text-danger">
            (Please don't use public Computer or Area)
          </span>
                </label>
            </div>
        </div>

        <div class="form-group">
            <button class="btn btn-primary btn-lg btn-block" type="submit">
                Login
            </button>
        </div>

        <div>
            <p class="text-center">
                If you are not Our member?
            </p>
            <p class="text-center">
                <a href="{{ route('remind.create') }}"></a>
                Forget Password?
            </p>
        </div>
    </form>
@stop