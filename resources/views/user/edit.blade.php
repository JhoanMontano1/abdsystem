@if (Auth::user()->type!=1)
<script>
 window.location.href = '{{url("/")}}';
</script>
@endif
@include('componentes.header')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Editar usuario</div>
                <div class="card-body">
                    <form method="POST" action="{{url('/user/'.$user->id)}}">
@csrf
{{ method_field('PUT') }}
<a href="{{url('/user')}}" class="btn btn-primary">Volver</a>
@include('user.form',['e'=>'Editar'])
</form>
                </div>
            </div>
        </div>
    </div>
</div>