<h1>{{$e}} Forma de entrada</h1>
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
<label for="tipo">Tipo</label>
<input type="varchar" class="form-control" name="tipo" value="{{isset($forma_entrada->tipo)?$forma_entrada->tipo:old('tipo')}}">
<br>
</div>
<br>
<br>
<input  class="btn btn-success" type="submit" value="{{$e}} forma de entrada">
<br>
<br>
<a  class="btn btn-primary"href="{{url('forma_entrada/')}}">Volver</a>
<br> 
@include('componentes.footer')