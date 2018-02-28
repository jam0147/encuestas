@extends('admin.layouts.app')

@section('main-content')
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
	  <!-- Content Header (Page header) -->
	  <section class="content-header">
	    
	    <ol class="breadcrumb">
	      <li><a href="{{ route('polls.index') }}"> Inicio </a> / <a href="{{ route('polls.index') }}"> Inicio </a>Encuestas </li>
	    </ol>
	  </section>

	  <!-- Main content -->
	  <section class="content">
		    <div class="row">
		      <div class="col-lg-12">
				<div class="box box-primary">
					<h2 class="titulo">
			      		Editar Encuesta
				    </h2>
					@include('includes.messages')      

					<form role="form" action="{{ route('polls.update', $poll->id) }}" method="post">
						{{ csrf_field() }}
						{{ method_field('PUT') }}
						<div class="box-body">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
									<label for="categoria">Categoria</label><br>
									<select name="category_id" id="" class="form-control">
										@foreach ($categories as $item)
											<option value="{{$item->id}}">{{$item->name}}</option>
										@endforeach
									</select>	                
								</div>

								<div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
									<label for="name">Nombre de la encuesta</label>
									<input type="text" class="form-control" id="name" name="name" placeholder="Nombre de la encuesta" value="{{ $poll->name }}">
								</div>

								<div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12" style="margin-top: 25px;">
									<button type="submit" class="btn btn-primary">Guardar</button>
									<a href='{{ route('polls.index') }}' class="btn btn-warning">Regresar</a>
								</div>
							</div>
						</div>
					</form>
				</div>
		        <!-- /.box -->
		        
		      </div>
		      <!-- /.col-->
		    </div>
		    <!-- ./row -->

		    <div class="row">
		    	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		    		<div class="box box-primary">
			    		<h2 class="titulo"> Preguntas de la Encuesta </h2>
				    	<input type="button" id="addPregunta" name="addPregunta" class="btn bg-light-blue pull-right" value="Agregar Pregunta" data-toggle="modal" data-target="#modalPreguntas" poll_id="{{$poll->id}}">

				    	<div class="clearfix"></div>

						<div id="col-lg-12 col-md-12 col-sm-12 col-xs-12 contenedorPreguntas">
							@if (!empty($questions))
								@foreach($questions as $item)
									<div class="box-body">
										<table class="table table-bordered tblPregunta" question_id="{{ $item->id }}">
											<tr>
												<th style="width: 10px">{{ $loop->iteration }}</th>
												<th class="question" id="{{ $item->id }}">
													<input type="hidden" id="question_id" value="{{ $item->id }}">

													<a class="linkPregunta" href="#" id_pregunta="{{ $item->id }}">
														{{ $item->name }}
													</a>
												</th>

												<th style="width: 65px">
													<span name="addRespuesta" class="btn btn-success btn-xs addRespuesta" title="Agregar Respuesta"  data-toggle="modal" data-target="#modalRespuestas" poll_id="{{$poll->id}}" question_id="{{ $item->id }}"> <i class="fa fa-plus"></i> </span>
													<span class="btn btn-danger btn-xs eliminarPregunta" title="Eliminar Pregunta"> <i class="fa fa-minus"></i> </span>

												</th>
												<th style="width: 20px">Valoracion</th>
											</tr>

											@if (!empty($item->answers))
												@foreach($item->answers as $answer)
												<tr>
													<td>-</td>
													<td class="answer" answer_id="{{ $answer->id }}" data-toggle="modal" data-target="#answerModal">
														{{ $answer->name }}
													</td>
													<td class="text-center"> <span class="btn btn-danger btn-xs btnEliminarRespuesta" answer_id="{{ $answer->id }}"> <i class="fa fa-remove"></i> </span> </td>		               
													<td>
														<span class="badge bg-light-blue">{{ $answer->value }}</span>
													</td>
												</tr>
												@endforeach
											@endif      
										</table>
									</div>
								@endforeach	{{-- FIN PREGUNTAS --}}
							@endif
						</div>
		    		</div>
		    	</div>
		    </div>

	  </section>
	  <!-- /.content -->
	</div>
	<!-- /.content-wrapper -->

	<div class="modal fade" id="modalPreguntas" tabindex="-1" role="dialog" aria-labelledby="modalPreguntasLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 class="modal-title" id="modalPreguntasLabel">Crear Pregunta</h3>
				</div>

				<div class="modal-body">
					<form id="fPregunta" role="form">
			            {{ csrf_field() }}
			            {{ method_field('PUT') }}
			            <input type="hidden" name="poll_id" value="0">
			            <input type="hidden" name="pregunta_id" value="0">
	              
	              		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 form-group">
			                    <label for="name">Nombre de la pregunta</label>
			                  	<input type="text" class="form-control" id="name" name="name" placeholder="pregunta" value="">
			                </div>

			                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 form-group">
			                  <label for="slug">¿Múltiples respuestas?</label>
			                  <br>
			                  <input type="radio" name="multiple_answers" value="1" checked="checked" > Si<br>
			                  <input type="radio" name="multiple_answers" value="0"> No<br>
			                </div>
			              </div>
	           		</form>

	           		<div class="clearfix"></div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					<button id="guardarPregunta" type="button" class="btn btn-primary">Guardar</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modalRespuestas" tabindex="-1" role="dialog" aria-labelledby="modalRespuestasLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 class="modal-title" id="modalRespuestasLabel"> Respuestas </h3>
					<h4 class="modal-title"> Respuesta </h4>
				</div>

				<div class="modal-body">
					<form id="fRespuesta" role="form">
			            {{ csrf_field() }}
			            {{ method_field('PUT') }}
			            <input type="hidden" name="poll_id" value="{{$poll->id}}">
              			<input type="hidden" name="question_id" value="0">
              			<input type="hidden" name="answer_id" value="0">
	              
	              		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 form-group">
			                    <label for="name">Respuesta</label>
			                  <input type="text" class="form-control" id="name" name="name" placeholder="Respuesta">
			                </div>

			                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 form-group">
			                    <label for="name">Valoracion</label>
			                  <input type="number" class="form-control" id="value" name="value" placeholder="Valoracion" min="0" required>
			                </div>
			            </div>
	           		</form>

	           		<div class="clearfix"></div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					<button id="guardarRespuesta" type="button" class="btn btn-primary">Guardar</button>
				</div>
			</div>
		</div>
	</div>
@endsection

@push('css')
	<style type="text/css">
		h2.titulo{
			border-bottom: 1px solid #EAEAEA;
			padding-left: 10px;
		}

		.box.box-primary{padding: 10px;}
	</style>
@endpush

@push('js')
	<script type="text/javascript">
		$(function(){
			$("#addPregunta").click(function(){
				limpiarModal("modalPreguntas");
				$("input[name='poll_id']", "#fPregunta").val($(this).attr('poll_id'));
			});

			$("span[name='addRespuesta']").click(function(){
				limpiarModal("modalRespuestas");

				$("#modalRespuestasLabel").html($(".linkPregunta", $(this).parents(".tblPregunta")).html());
				$("input[name='poll_id']", "#fRespuesta").val($(this).attr('poll_id'));
				$("input[name='question_id']", "#fRespuesta").val($(this).attr('question_id'));
			});

			$(".linkPregunta").click(function(){
				buscarInfoPregunta($(this).attr("id_pregunta"));
				$("#modalPreguntas").modal("show");
			});

			$("#guardarPregunta").click(function(){
				$url = '{{ url('admin/questions/guardar/1') }}';

				if($("input[name='pregunta_id']", "#fPregunta").val() > 0)
					$url = '{{ url('admin/questions/actualizar') }}/' + $("input[name='pregunta_id']", "#fPregunta").val();

				$.ajax({
					url : $url,
					data: $("#fPregunta").serialize(),
					dataType:'json',
					type:'PUT',
					method:'PUT',
					success:function(r){
						if(r.s == 's'){
							$("#modalPreguntas").modal("hide");
							alert("Pregunta Guardada Satisfactoriamente");
							location.reload();
						}
					}
				});
			});

			$("#guardarRespuesta").click(function(){
				$url = '{{ url('admin/answers/guardar/1') }}';

				if($("input[name='answer_id']", "#fRespuesta").val() > 0)
					$url = '{{ url('admin/answers/actualizar') }}/' + $("input[name='answer_id']", "#fRespuesta").val();

				$.ajax({
					url : $url,
					data: $("#fRespuesta").serialize(),
					dataType:'json',
					type:'PUT',
					method:'PUT',
					success:function(r){
						if(r.s == 's'){
							agregarRespuestaTabla(r.respuesta.question_id, r.respuesta);
							$("#modalRespuestas").modal("hide");
						}
					}
				});
			});

			$(".btnEliminarRespuesta").click(function(){
				if(!confirm("¿Realmente desea eliminar esta respuesta?"))
					return false;
				$btn = $(this);
				$.ajax({
					url 	 : '{{ url('admin/answers/eliminar') }}/' + $(this).attr('answer_id'),
					dataType :'json',
					type 	 :'GET',
					success  :function(r){
						alert(r.msj);
						if(r.s == 's'){
							$btn.parents("tr").detach();
						}
					}
				});
				
			});
		});

		function buscarInfoPregunta(id){
			limpiarModal("modalPreguntas");

			$("input[name='pregunta_id']", "#fPregunta").val(id);

			$.ajax({
				url 	 : '{{ url('admin/questions/buscar') }}/' + id,
				dataType :'json',
				type 	 :'GET',
				success  :function(r){
					if(r.s == 's'){
						$("input[name='poll_id']", "#fPregunta").val(r.questions.poll_id);
						$("input[name='name']", "#fPregunta").val(r.questions.name);
						$("input[name='multiple_answers'][value='"+ r.questions.multiple_answers +"']", "#fPregunta").prop('checked', 'checked');
					}
				}
			});
		}

		function limpiarModal(id_modal){
			$("input[type='text'], input[type='hidden'][name!='_token'][name!='_method'], select", "#" +  id_modal).val('');
			$("input[type='radio']", "#" + id_modal).prop('checked', false);
		}

		function agregarRespuestaTabla($question_id, $info){
			$(".tblPregunta[question_id='"+ $question_id +"']").append("<tr class='answer'><td>-</td><td answer_id='"+ $info.id +"'> "+ $info.name +" </td> <td class='text-center'> <span class='btn btn-danger btn-xs btnEliminarRespuesta'> <i class='fa fa-remove'></i> </span> </td>	 <td><span class='badge bg-light-blue'> " + $info.value + " </span></td></tr>");
		}
	</script>
@endpush