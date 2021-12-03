@section('content')
@extends('componentes.header')
<style>
.container1 {
    background-color: #E7ECF9;
    padding: 10%;
    margin: 0px;
    display: flex;
    justify-content: center;
    width: 100%;
    height: 720px;

}

.item {
    text-align: center;
    padding: 0%;
    margin: -1%;
}

.item2>h1,
h2,
h3,
h5 {
    color: #7C7C7C;
}

.item1 {
    width: 100%;
}

.item2 {
    padding-top: 5%;
    width: 100%;
    background-color: white;
}

#btnLogin {
    opacity: 0.5;
    background-image:url("{{asset('img/btnIniciar.svg')}}");
    background-repeat: no-repeat;
    width: 200px;
    height: 30px;
    border: 0;
    background-color: transparent;
}

#btnLogin:hover {
    opacity: 1.0;
}
@media (max-width: 400px){
.item1{
    display:none;
}
}
</style>
<div class="container1">
    <div class="item item1">
        <img src="{{asset('img/loginBanner.svg')}}" width="100%" height="100%" alt="" srcset="">
    </div>

    <div class="item item2">
        <h3 style="color:#2A7FFE;">¡Hola de nuevo!</h3>
        <br>
        <h1 style="color:#2A7FFE;">Bienvenido</h1>
        <br>
        <br>
        <h5>Iniciar sesión</h5>
        <br>
        <br>
        <div class="text-center">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="d-flex flex-row justify-content-center align-items-center">
                    <div class="col-md-6">
                        <input id="email" placeholder="Usuario" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>


                </div>
                <br>
                <div class="d-flex flex-row justify-content-center align-items-center">
                    <div class="col-md-6">
                        <input id="password" placeholder="Contraseña" type="password"
                            class="form-control @error('password') is-invalid @enderror" name="password" required
                            autocomplete="current-password">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
<br>
                <div class="d-flex flex-row justify-content-center align-items-center">
                    <div class="col-md-8">
                        <button type="submit" id="btnLogin">
                        </button>

                    </div>
                </div>


            </form>
        </div>

    </div>
</div>
@include('componentes.footer')
@endsection