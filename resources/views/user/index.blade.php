@if (Auth::user()->type!=1)
<script>
window.location.href = '{{url("/")}}';
</script>
@endif

@include('componentes.header')
<style>
th,
td {
    vertical-align: middle;
}
</style>
<h1 style="text-align: center;">Usuarios</h1>

<div class="container">
    @if(Session::has('mensaje'))
    <div class="alert alert-success alert_dismissible" role="alert">

        {{Session::get('mensaje')}}

    </div>
    @endif
    <!-- <form action="{{url('/report')}}" method="get">
<input type="hidden" name="context" value="user" >
<input type="submit" value="Reporte" class="btn btn-primary">
</form> -->
    <a class="btn btn-primary" href="{{ url('user/create') }}">Nuevo usuario</a>


    <br />
    <br />
    <div class="table-responsive">
        <table class="table">
            <thead class="">
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Privilegio</th>
                    <th>Accion</th>
                </tr>
            </thead>
            <tbody>
                @foreach($user as $users)
                <tr>
                    <td>{{ $users->id}}</td>
                    <td>{{ $users->name}}</td>
                    <td>{{ $users->email}}</td>
                    <!-- <td>{{ $users->password}}</td> -->
                    <td>{{ $users->type==1 ?'Admin' :'Normal'}}</td>

                    @if ($users->id!=Auth::user()->id and $users->id!=1)
                    <td>
                        <div class="d-flex">
                            <button class="btn btn-warning btn-sm mb-1">
                                <a href="{{url('/user/'.$users->id.'/edit')}}">
                                    <img class="icon" src="{{asset('img/nuevoEditar.svg')}}" alt="" srcset="">
                                </a>
                            </button>
                            <p></p>
                            <form action="{{ url('/user/'.$users->id) }}" method="post">
                                @csrf
                                {{method_field('DELETE')}}
                                <button type="submit"
                                    onclick="return confirm('Seguro:¿Qué quieres eliminar este usuario?')"
                                    class="btn btn-danger btn-sm">
                                    <img class="icon" src="{{asset('img/nuevoEliminar.svg')}}" alt="" srcset="">
                                </button>
                            </form>
                        </div>

                    </td>

                    @else
                    <td>
                        <button class="btn btn-info" disabled>Sin acciones</button>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>

        </table>

    </div>

</div>
{{$user->links()}}

@include('componentes.footer')