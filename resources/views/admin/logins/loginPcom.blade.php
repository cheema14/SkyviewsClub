@extends('layouts.'.tenant()->id.'.loginLayout')
@section('content')

    <form method="POST" class="w-100 my-4" action="{{ route('login') }}">
        @csrf

        <div class="input-group d-flex flex-column mb-3">
            <span class="input-icons">
                <img src="{{ asset('img/pcom/email.png')}}" alt="">
            </span>
            <input id="username" name="username" type="text" class="login-inputs {{ $errors->has('username') ? ' is-invalid' : '' }}"  required autocomplete="username" autofocus placeholder="Username" value="{{ old('username', null) }}">
            @if($errors->has('username'))
                <div class="invalid-feedback">
                    {{ $errors->first('username') }}
                </div>
            @endif
        </div>
        <div class="input-group d-flex flex-column">
            <span class="input-icons">
                <img src="{{ asset('img/pcom/padlock.png')}}" alt="">
            </span>

            <input id="password" name="password" type="password" class="login-inputs {{ $errors->has('password') ? ' is-invalid' : '' }}" required placeholder="{{ trans(tenant()->id .'/global.login_password') }}">

            @if($errors->has('password'))
                <div class="invalid-feedback">
                    {{ $errors->first('password') }}
                </div>
            @endif
        </div>

        <div class="w-100 d-flex align-items-center justify-content-between custom-flex">
            {{-- <div class="left-check"><input type="checkbox" name="" id="" class="m-2">Remember me</div> --}}
            {{-- <div class="right-check">Forgot Password?</div> --}}
        </div>
        <button type="submit" class="submit-btn-login">{{ trans(tenant()->id .'/global.login') }}</button>
    </form>
@endsection
