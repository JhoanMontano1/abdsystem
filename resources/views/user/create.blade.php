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
                <div class="card-header">Registrar usuario</div>
                <div class="card-body">
                    <form method="POST" action="{{url('/user')}}">
@csrf
<a href="{{url('/user')}}" class="btn btn-primary">Volver</a>
@include('user.form',['e'=>'Registrar'])

</form>

                </div>
            </div>
        </div>
    </div>
</div>