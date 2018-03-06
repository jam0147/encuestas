@extends('user.layouts.app2')
@section('content')
<div class="container">
  <br><br><br><br>
    <div class="row">
    <p>{{-- categoria  {{ $encuesta->category }} --}}
      @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
      @endif
    </p>
        <input  type="hidden" id="seconds" value="{{ $encuesta->category->seconds }}" >
        <form action="{{ route('encuestas.store') }}" method="post" id="formid"> 
            {{ csrf_field()  }} 
            <input type="hidden" name="poll_id" value="{{ $encuesta->id }}">
            <div class="myform">
                {{-- <input type="hidden" name="respuesta_id[]" value="">     --}}
            </div>
          <div class="col-md-12">
            <div class=""><br>               
                <div class="sec-title text-center">
                  <h2 class="wow animated text-center" style="color: #999999;"> {{ $encuesta->name }}</h2>
                </div>
                @if ($encuesta->category->timer_type >1)                
                  <div style="text-align:center;">
                    <p>Tiempo para responder: {{ $encuesta->category->hour }}:{{ $encuesta->category->minutes }}:{{ $encuesta->category->seconds }}</p>
                    <div id="cabecera"></div>
                    <p>Tiempo restante:</p>
                    <div style="color:#337ab7; font-family: verdana, arial; font-size:30px; padding:15px;" id ="displayReloj" > &nbsp;
                    </div>
                    <h2 id='CuentaAtras'></h2>
                  </div>
                @endif
                <div>
                  @if (!$preguntas == null)
                    @foreach ($preguntas as $pregunta)
                      <div class="row">
                          <div class="col-md-12 col-xs-12">
                              <div class="panel panel-primary">
                                  <div class="panel-heading">
                                    <h3 class="panel-title">
                                      <span class="glyphicon "></span>{{  $pregunta->name }}? <a href="http://www.jquery2dotnet.com" target="_blank"><span
                                          class="glyphicon "></span></a>
                                    </h3>
                                  </div>
                                  <div class="panel-body">
                                    <div class="radio">
                                      @if (!empty($pregunta->answers))
                                        @foreach($pregunta->answers as $answer)
                                          @if ($pregunta->multiple_answers == 1)
                                              <div style="float: left;padding: 6px;margin-bottom: 8px;border: 1px solid #bad3e8;border-radius: 10px; width: 100%;     font-weight: bold !important;">
                                                <input type="checkbox" 
                                                name="respuestas" 
                                                value="{{ $answer->id }}" 
                                                class="chk" 
                                                id="{{ $answer->id }}"
                                                @if (!$contestadas == null)
                                                  @foreach ($contestadas as $item)
                                                    @if ($item->answer_id == $answer->id)
                                                      checked
                                                    @endif
                                                  @endforeach
                                                @endif
                                                > 
                                                {{ $answer->name }}
                                              </div>
                                          @else
                                            <div style="float: left;padding: 6px; margin-bottom: 8px; border: 1px solid #bad3e8; border-radius: 10px;width: 100%;     font-weight: bold !important;">
                                              <input type="radio" 
                                              name="respuestas{{$pregunta->id}}" 
                                              value="{{ $answer->id }}" 
                                              class="rad" 
                                              id="{{ $answer->id }}" 
                                              @if (!$contestadas == null)
                                                @foreach ($contestadas as $item)
                                                  @if ($item->answer_id == $answer->id)
                                                    checked
                                                  @endif
                                                @endforeach
                                              @endif
                                              style="margin-left: 0px !important; "
                                              >
                                                <label style="font-weight: bold;">
                                                  {{ $answer->name }}
                                                </label> 
                                            </div>
                                          @endif  
                                        @endforeach
                                      @endif
                                    </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                    @endforeach
                  @endif
                </div>
                <!-- <input type="submit"   value="Registrar encuesta" > --> 
                <button id="evaluar" class="btn btn-danger">Terminar encuesta</button>
                @if($encuesta->category->pausable == 0)
                    <input type="hidden" name="pausable" value="0">                    
                @else
                    <button id="pausar" class="btn btn-success">pausar encuesta</button>
                    <input type="hidden" name="pausable" value="1">                    
                @endif
                <input type="text" id="arreglo" class="form-control" placeholder="" name="arreglo[]">
            </div>
        </div>
          </form>
    </div>
    @php
      $timer = 0;
      if ($encuesta->category->hour > 0 || $encuesta->category->minutes > 0 || $encuesta->category->seconds > 0) 
        $timer = 1;
    @endphp
</div>
<script src="{{ asset('admin/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
<script>    
var $horas    = "{{ $encuesta->category->hour }}";
var $minutos  = "{{ $encuesta->category->minutes }}";
var $segundos = "{{ $encuesta->category->seconds }}";
var poll_id = "{{ $encuesta->id }}";
var $timer = "{{ $timer }}";
$(function () {  
  
  $("input:submit").click(function() { return false; });
  
  $("input", ".radio").click(function(){
    $divRadio = $(this).parents('.radio');

    if($divRadio.hasClass('deshabilitada'))
      return false;

    $idRespuesta = $(this).attr('id');

    $("input.oculto[r='" + $idRespuesta + "']", $divRadio).detach();

    if($(this).attr('type') == 'radio')
      $("input.oculto", $divRadio).detach();

    if($(this).prop('checked')){
      $('<input>').attr({
          type  : 'hidden',
          name  : 'id_respuestas[]',
          value : $idRespuesta,
          'r'   : $idRespuesta,
          class : 'oculto'
      }).appendTo($divRadio);
    }
  });

  //Encuesta por tiempo
  if ($timer == 1){
    var n = 0;
    var nn = 0;
    var hour = $horas;
    var min = $minutos;
    var seg = $segundos;

    if ( hour == null || hour == '') {hour=0; }
    if ( min == null || min == '') {min=0; }
    if ( seg == null || seg == '') {seg=0; }

    //reloj();
  }
});

function enviarDatos(){
  document.getElementById('evaluar').click();
}

function reloj() {
  if (seg > 0)
  seg = seg - 1;

  if ((min > 0)  && (seg == 0)){
    min = min - 1;
    seg = 60;
  }

  if ((hour > 0) && (min == 0)){
    hour = hour - 1;
    min = 60;
  }

  document.getElementById('displayReloj').innerHTML = hour + " : " + min + " : " + seg;

  if ((hour == 0) && (min == 0) && (seg == 0))
    enviarDatos();

  var t = setTimeout(function(){ reloj() }, 1000 );
}
</script>

@endsection


