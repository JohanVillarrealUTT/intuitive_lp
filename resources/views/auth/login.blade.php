@extends('layouts.admin')
@section('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('css/master.css') }}">
<style>
	.container-login{
		text-align: right;
		padding: 1rem 0rem;
	}
	@media (min-width: 650px) {
		.container-login{
			display: grid;
			grid-template-columns: 1fr;
			grid-template-rows: 1fr 5fr auto;
			grid-template-columns: 368px auto;
			height: calc(100vh - 170px);
			
		}
	}
	.header-logo {
		padding-top: 0rem;
		padding-bottom: 0rem;
	}
	.form-login{
        grid-row: 2;
        margin: 0;
	}
	.login-title{
		color: #666;
        font-size: 1.75rem;
        text-align: left;
	}
	.login-subtitle{
		color: #999;
        font-size: 1rem;
        text-align: left;
        margin: 0 0 2rem;
		}
	.group{
		display: flex;
    	justify-content: space-between;
	}
    .form-label {
        display: block;
        font-weight: bold;
        margin-bottom: 20px;
        text-align: left;
    }
    .error {
		color: salmon;
		margin-bottom: 0.5rem;
		margin-top: 0.5rem;
	}
    .alert-success, .alert-error{
        color:#666;
        margin-bottom: 1.5rem;
        padding: 1rem;
        text-align: center;
    }

    .alert-error {
        background-color: #fdc3bc;
    }
    .alert-success {
        background-color: #66FF66;
    }
</style>
@endsection
@yield('styles')
@section('content')
<div class="container">
	<div class="container-login">
		
		<form class="form-login" role="form" method="POST" action="{{ url('/login') }}">
			@if (count($errors))
				<div class="alert-error"> Verifique la información ingresada. </div>
			@endif
			<div class="login-title" >Inicia sesión </div>

			<p class="login-subtitle"> Ingresá tus datos de acceso para iniciar sesión. </p>

			<input type="hidden" name="_token" value="{{ csrf_token() }}">

			<label class="form-label">
				<v-input label="Correo electrónico" type="email"  name="email" value="{{ old('email') }}"></v-input>
			</label>

			<label class="form-label">
				<v-input label="Password" value="" type="password" name="password"></v-input>
			</label>

			<label class="form-label">
				<span class="group">
					<label class= "form-rememberCheckbox"> <input type="checkbox" name="remember"> Recuerdame</label>
					<a class="btn btn-link" href="{{ url('/password/reset') }}">¿Olvidaste tu contraseña?</a>
				</span>
			</label>
			<v-button>Iniciar sesión</v-button>		
		</form>

	</div>
</div>
@endsection
