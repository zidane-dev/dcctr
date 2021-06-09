@extends('layouts.app')

@section('content')
    <img class="wave" src="{{asset('img/wave.png')}}">
    <div class="container">
        <div class="img">
            <img src="{{asset('img/bg.svg')}}">
        </div>

        <div class="login-content">

            <form method="POST" action="{{route('login') }}">
                @csrf
                <img class="img_mobile" src="{{asset('img/logo.png')}}" >
                @include('layouts.errors_success')
                <h2 class="title"></h2>
                <div class="input-div one">
                    <div class="i">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="div">

                        <input type="email"  name="email" placeholder="Email">
                    </div>
                </div>
                <div class="input-div pass">
                    <div class="i">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="div">

                        <input type="password"  name="password" placeholder="Mot De Passe">
                    </div>
                </div>
                <br>
                @if (Route::has('password.request'))
                <a href="{{route('password.request')}}">Mot de passe oublié ?</a>
                @endif
                <input type="submit" class="btn" value="S'authentifier">
            </form>
        </div>
    </div>
@endsection
