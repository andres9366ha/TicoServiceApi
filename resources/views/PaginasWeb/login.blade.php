@extends('layouts.app')

@section('title', 'Login')

@section('content')

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">TicoService</a>
    </div>

    <ul class="nav navbar-nav navbar-right">
      <li><a href="{{ url('busqueda') }}"><span class="glyphicon glyphicon-home"></span> Inicio</a></li>
      <li><a href="{{ url('registro') }}"><span class="glyphicon glyphicon-user"></span> Registarse</a></li>
    </ul>
  </div>
</nav>

{{ Form::open(array('url' => 'api/user/login', 'method' => 'POST'), array('role' => 'form')) }}
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
  <!-- <div class="row"> -->
    <!-- <div class="col-md-offset-4 col-md-4 col-md-offset-4"> -->
      @include('flash::message')
    <!-- </div> -->
  <!-- </div> -->
{{ Form::button('Iniciar Sesión', array('type' => 'submit', 'class' => 'btn btn-primary')) }}
</div>
</div>
{{ Form::close() }}



@endsection
