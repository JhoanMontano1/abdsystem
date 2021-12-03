<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
<style>
            @font-face {
      font-family: "Montserrat";
      src: url("{{asset('font/Montserrat/Montserrat-SemiBold.ttf')}}");
    }
        .nav-link,.navbar-brand{
            color:white;
            font-family:"Montserrat";
            
        }
        .navbar-brand{
            
        }
        .element{

            opacity: 0.8;
        }
        .element:hover{
            color:white;
            opacity: 1.0;
            
        }
        .icon{
            width:24px;
            height:22px;
            padding:0;
            padding-bottom:2px;
            margin:0;
        }
        .logo{
            margin:0;
            padding:0;
        }
        .option{
            padding-left:2%;

        }
        .navbar-toggler{
            color:white;
        }
        #submenu,#submeno>a{
            background-color:#E7ECF9;
            font-family:"Montserrat";
            
        }

 p{
   display:inline;  
   padding-left:10px;
 }
 h1{
  font-family:"Montserrat";
 }
 #reporte{

border:0;
background:url("{{asset('img/reporte.svg')}}");
background-repeat: no-repeat;
 }
 #reporte:focus{
		box-shadow: none;
	}
  .accion:focus{
    box-shadow: none;
  }
  .accion{
    border:0;
  }
  #eliminar{
    background:url('{{asset("img/nuevoEliminar.svg")}}');background-repeat: no-repeat;
  }
  #editar{
    background:url('{{asset("img/editar.svg")}}');background-repeat: no-repeat;
  }
  #expandIco{
background-image:url("{{asset('img/expandir01.svg')}}");
background-repeat:no-repeat;
}

}


    </style>
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ config('app.name', 'DavidSystem') }}</title>

<!-- Scripts -->
<script src="{{asset('js/app.js')}}"></script>

<!-- Fonts -->
<link rel="dns-prefetch" href="//fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

<!-- Styles -->
<link rel="stylesheet" href="{{asset('css/app.css')}}">

<!--#######################################################################################-->
@if (Auth::user())
<nav style="padding-left:5%; background-color:#2A7FFE;" class="navbar navbar-expand-lg">
  <a class="navbar-brand">  
  <img src="{{asset('img/logo.svg')}}" width="129px" height="30px" alt="" srcset=""></a>
  <button onclick="changeExpand()" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
 <div class="icon exp1" id="expandIco"></div>
  </button>

  
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item active option">
        <a class="navbar-brand element" href="{{ url('/') }}">  
                
                <img class="icon" src="{{asset('img/home 2.0-05.svg')}}" alt="" srcset="">
                Inicio
    </a>
    @if (Auth::user()->type==1)
      </li>
      <li class="nav-item option">
        <a class="navbar-brand element" href="{{ url('/user') }}">
        <img class="icon" src="{{asset('img/usuarios.svg')}}" alt="" srcset="">
        Usuarios
    </a>
    @endif
      </li>
      <li class="nav-item dropdown option">
        <a class="navbar-brand element dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <img class="icon" src="{{asset('img/inventario.svg')}}" alt="" srcset=""> 
        Inventario
        </a>
        <div class="dropdown-menu option" id="submenu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="{{ url('/articulo') }}">
              <img class="icon" src="{{asset('img/articulos.svg')}}" alt="" srcset="">
            <p></p>
              Artículo
            </a>
          <a class="dropdown-item" href="{{ url('/categoria') }}"><img class="icon" src="{{asset('img/categorias.svg')}}" alt="" srcset=""><p></p> Categoría</a>
          <a class="dropdown-item" href="{{ url('/entrada') }}"><img class="icon" src="{{asset('img/entradas.svg')}}" alt="" srcset=""><p></p> Entrada</a>
          <a class="dropdown-item" href="{{ url('/salida') }}"><img class="icon" src="{{asset('img/salidas.svg')}}" alt="" srcset=""><p></p> Salida</a>
          <a class="dropdown-item" href="{{ url('/cliente') }}"><img class="icon" src="{{asset('img/clientes.svg')}}" alt="" srcset=""><p></p> Cliente</a>
          <a class="dropdown-item" href="{{ url('/proveedor') }}"><img class="icon" src="{{asset('img/proveedor.svg')}}" alt="" srcset=""><p></p> Proveedor</a>
        </div>
      </li>

      <li class="nav-item dropdown option">
        <a class="navbar-brand element dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <img class="icon" src="{{asset('img/formas.svg')}}" alt="" srcset="">
        Formas
        </a>
        <div class="dropdown-menu option" id="submenu" aria-labelledby="navbarDropdownMenuLink">
        <a class="dropdown-item" href="{{ url('/forma_entrada') }}"><img class="icon" src="{{asset('img/forma_entrada.svg')}}" alt="" srcset=""><p></p> Formas entrada</a>
        <a class="dropdown-item" href="{{ url('/forma_salida') }}"><img class="icon" src="{{asset('img/forma_salida.svg')}}" alt="" srcset=""><p></p> Formas salida</a>
        <a class="dropdown-item" href="{{ url('/forma_pago') }}"><img class="icon" src="{{asset('img/forma_pago.svg')}}" alt="" srcset=""><p></p> Formas pago</a>
        </div>
      </li>

      <li class="nav-item dropdown option">
        <a class="navbar-brand element dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <img class="icon" src="{{asset('img/facturas.svg')}}" alt="" srcset=""> 
        Facturas
        </a>
        <div class="dropdown-menu option" id="submenu" aria-labelledby="navbarDropdownMenuLink">
        <a class="dropdown-item" href="{{ url('/factura_proveedor') }}"><img class="icon" src="{{asset('img/factura_entrada.svg')}}" alt="" srcset=""><p></p> Facturas de entrada</a>
        <a class="dropdown-item" href="{{ url('/factura_cliente') }}"><img class="icon" src="{{asset('img/factura_salida.svg')}}" alt="" srcset=""><p></p> Facturas de salida</a>
        </div>
      </li>


                @if (Auth::user())
      <li class="nav-item dropdown option">
        <a class="navbar-brand element dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <img class="icon" src="{{asset('img/usuarios.svg')}}" alt="" srcset="">
        {{ Auth::user()->name }}
        </a>
        <div class="dropdown-menu option" id="submenu" aria-labelledby="navbarDropdownMenuLink">
        <a class="dropdown-item"  href="{{ route('logout') }} btn-sm" onclick="event.preventDefault();
document.getElementById('logout-form').submit();">
                        <img src="{{asset('img/exit.svg')}}" class="icon" alt="logout">
                        {{ __('Logout') }}
                        
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </a>

        </div>
      </li>
@endif
    </ul>
  </div>
</nav>
@endif


 
    <div class="cont-2">

        <main class="py-4" style="text-align:right;">
            @yield('content')
        </main>
    </div>

