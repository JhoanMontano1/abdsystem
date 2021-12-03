<footer style="background-color:#2A7FFE;" class="page-footer font-small blue p-3 text-light">

  <!-- Copyright -->
  <div class="text-center"
  >Accesorios Bendicion de Dios © 2021. Todos Los Derechos Reservados
  </div>
  <!-- Copyright -->
<script>
  function changeExpand(){

if($("#expandIco").hasClass("exp1")){
  $("#expandIco").removeClass("exp1").addClass("exp2");
  $("#expandIco").css("background-image","url('{{asset('img/expandir02.svg')}}')");
  
  console.log("Actual icono 1");
}
else{
  $("#expandIco").removeClass("exp2").addClass("exp1");
  $("#expandIco").css("background-image","url('{{asset('img/expandir01.svg')}}')");
  console.log("Actual icono 2");
}

  }
</script>
</footer>