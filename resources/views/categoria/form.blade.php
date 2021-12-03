<h1>{{$e}} categoria</h1>
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
<input type="varchar" class="form-control" name="nombre" value="{{isset($categoria->nombre)?$categoria->nombre:old('nombre')}}">
<br>

</div>
<br>
<input  class="btn btn-success" type="submit" value="{{$e}} categoria">
<br>
<br>
<a  class="btn btn-primary"href="{{url('categoria/')}}">Volver</a>
<br> 
@include('componentes.footer')