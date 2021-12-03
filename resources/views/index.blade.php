@include('componentes.header')
<div class="text-center">
 <img   src="{{asset('img/logoCentral.svg')}}" width="80%" height="80%" alt="" srcset=""> 
</div>
<br>
<br>
@include('componentes.footer')  
<!-- @if (isset(Auth::user()->type))
{{ Auth::user()->type }}
@endif -->
