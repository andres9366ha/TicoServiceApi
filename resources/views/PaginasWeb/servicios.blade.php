@extends('layouts.app')

@section('title', 'Servicios')

@section('content')

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">TicoService</a>
    </div>

    <ul class="nav navbar-nav navbar-right">
      <li><a href="{{ url('') }}"><span class="glyphicon glyphicon-user"></span> Usuario logueado</a></li>
    </ul>
  </div>
</nav>

<div class="row">
<div class="form-group  col-md-offset-4 col-md-4 ">

  {{ Form::text('search', null, array('placeholder' => 'Introduce tu Busqueda', 'class' => 'form-control')) }}
</div>

<div class="form-group  col-md-4 ">
{{ Form::button('Busqueda', array('type' => 'submit', 'class' => 'btn btn-primary')) }}
</div>
</div>

<div class="col-md-2"></div>
<div class="col-md-8">
  <table class="table table-striped">
   <thead>
     <tr>
       <th>SERVICIO</th>
       <th>DESCRIPCIÓN</th>
       <th>ACCIONES</th>
     </tr>
   </thead>
   <tbody>
     <?php
         foreach ($services as $key) {
           echo "<tr><td>".$key->name."</td><td>".$key->description."</td>
           <td><button type='button' name='.$key->id.' class='btn btn-warning'>Editar</button>
           <button type='button' name='.$key->id.' class='btn btn-danger'>Eliminar</button>
           </tr>";
         }
      ?>
   </tbody>
 </table>

</div>
