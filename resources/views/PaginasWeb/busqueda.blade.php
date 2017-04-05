
@extends('layouts.app')

@section('title', 'Busqueda')


@section('content')


<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">TicoService</a>
    </div>

    <ul class="nav navbar-nav">
      <li class="active"><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>

    </ul>

    <ul class="nav navbar-nav navbar-right">
      <li id="register"><a href="{{ url('registro') }}"><span class="glyphicon glyphicon-user"></span>{{ isset($name) ? $name : 'Registrarse' }}</a></li>
      <li id="login"><a href="{{ url('login') }}"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
    </ul>
  </div>
</nav>

{{ Form::open(array('url' => 'api/user/login', 'method' => 'POST'), array('role' => 'form')) }}
<div class="row">
<div class="form-group  col-md-offset-4 col-md-4 ">

  {{ Form::text('search', null, array('placeholder' => 'Introduce tu Busqueda', 'class' => 'form-control')) }}
</div>

<div class="form-group  col-md-4 ">
{{ Form::button('Busqueda', array('type' => 'submit', 'class' => 'btn btn-primary')) }}
</div>
</div>
{{ Form::close() }}
@endsection

<script type="text/javascript">

    var login = document.getElementById('login');
    var register = document.getElementById('register');
        = showContent;
        // Hide content divs by default
//        getContentDiv(link).style.display = 'none';

</script>​
