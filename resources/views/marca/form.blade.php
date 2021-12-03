<h1>{{$e}} marca</h1>
@if(count($errors)>0)
<div class="alert alert-danger" role="alert">
<ul>

@foreach($errors->all() as $errors)
<li>{{$errors}}</li>
@endforeach	
</ul>
</div>

@endif
<div class="form-group">
<label for="nombre">Nombre</label>
<input type="varchar" class="form-control" name="nombre" value="{{isset($marca->nombre)?$marca->nombre:old('nombre')}}">
<br>
<br>
<input  class="btn btn-success" type="submit" value="{{$e}} marca">
<br>
<br>
<a  class="btn btn-primary"href="{{url('marca/')}}">Volver</a>
<br> 
@include('componentes.footer')