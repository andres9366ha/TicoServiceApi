@extends('layouts.app')

@section('title', 'Registro')

@section('content')

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">TicoService</a>
    </div>

    <ul class="nav navbar-nav navbar-right">
      <li><a href="{{ url('busqueda') }}"><span class="glyphicon glyphicon-home"></span> Inicio</a></li>
      <li><a href="{{ url('login') }}"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
    </ul>
  </div>
</nav>

{{ Form::open(array('url' => 'api/user', 'method' => 'POST'), array('role' => 'form')) }}
<div class="row">
<div class="form-group  col-md-offset-4 col-md-4 col-md-offset-4">
  {{ Form::label('name', 'Nombre') }}
  {{ Form::text('name', null, array('placeholder' => 'Introduce tu Nombre', 'class' => 'form-control')) }}
</div>
</div>

<div class="row">
<div class="form-group  col-md-offset-4 col-md-4 col-md-offset-4">
  {{ Form::label('last_name', 'Apellidos') }}
  {{ Form::text('last_name', null, array('placeholder' => 'Introduce tus Apellidos', 'class' => 'form-control')) }}
</div>
</div>

<div class="row">
<div class="form-group  col-md-offset-4 col-md-4 col-md-offset-4">
  {{ Form::label('phone', 'Telefono') }}
  {{ Form::number('phone', null, array('placeholder' => 'Introduce tu Telefono', 'class' => 'form-control')) }}
</div>
</div>

<div class="row">
<div class="form-group  col-md-offset-4 col-md-4 col-md-offset-4">
  {{ Form::label('email', 'Dirección de E-mail') }}
  {{ Form::email('email', null, array('placeholder' => 'Introduce tu E-mail', 'class' => 'form-control')) }}
</div>
</div>

<div class="row">
<div class="form-group col-md-offset-4 col-md-4 col-md-offset-4">
  {{ Form::label('password', 'Contraseña') }}
  {{ Form::password('password', array('placeholder' => 'Introduce tu Contraseña', 'class' => 'form-control')) }}
</div>
</div>

<div class="row">
<div class="form-group col-md-offset-4 col-md-4 col-md-offset-4">
  {{ Form::label('Confirm_password', 'Confirmar Contraseña') }}
  {{ Form::password('Confirm_password', array('placeholder' => 'Introduce nuevamente la Contraseña', 'class' => 'form-control')) }}
</div>
</div>

<div class="row">
<div class="form-group col-md-offset-4 col-md-4 col-md-offset-4">
@include('flash::message')
{{ Form::button('Registarme', array('type' => 'submit', 'class' => 'btn btn-primary')) }}
</div>
</div>


{{ Form::close() }}
@endsection
