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
        	grid-template-rows: repeat(3, 1fr);
			grid-template-columns: 500px auto;
			height: calc(100vh - 170px);
			
		}
	}
	.header-logo {
		padding-top: 0rem;
		padding-bottom: 0rem;
	}
	.form-horizontal {
        grid-row: 2;
        margin: 0;
	}
	.login-title {
		color: #666;
        font-size: 1.75rem;
        text-align: left;
	}
	.login-subtitle {
		color: #999;
        font-size: 1rem;
        text-align: left;
        margin: 0 0 2rem;
		}
    .form-label {
        display: block;
        font-weight: bold;
        margin-bottom: 20px;
    }
    .error {
		color: salmon;
		margin-bottom: 0.5rem;
		margin-top: 0.5rem;
	}
    .alert-error {
        background-color: #fdc3bc;
        color:#666;
        margin-bottom: 1.5rem;
        padding: 1rem;
        text-align: center;
    }
</style>
@endsection
@yield('styles')
@section('content')
<div class="container">
	<div class="container-login">

		<form class="form-horizontal" role="form" method="POST" action="{{ url('/password/reset') }}">

			@if (count($errors))
				<div class="alert-error text-center"> Verifique la información ingresada. </div>
			@endif
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<input type="hidden" name="token" value="{{ $token }}">

			<div class="login-title" >Reinciar contraseña</div>

			<p class="login-subtitle"> Ingresá tu correo electrónico y tu nueva contraseña. </p>

			<label class="form-label">
				<v-input label="Correo electrónico" type="email"  name="email" value=""></v-input>
			</label>

			<label class="form-label">
				<v-input label="Contraseña" type="password"  name="password" value=""></v-input>
			</label>

			<label class="form-label">
				<v-input label="Confirmar Contraseña" type="password"  name="password_confirmation" value=""></v-input>
			</label>

			<span class="group-buttons">
				<v-button>Guardar contraseña</v-button>	
			</span>
		</form>
	</div>
</div>
@endsection

