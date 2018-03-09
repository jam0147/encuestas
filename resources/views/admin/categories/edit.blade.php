@extends('admin.layouts.app')

@section('main-content')
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
	  <!-- Content Header (Page header) -->
	  <section class="content-header">
	    
	    <ol class="breadcrumb" style="font-size: 20px">
	      <li><a href="{{ route('categories.index') }}"><i class="fa fa-dashboard"></i> Index</a></li>
	    </ol>
	  </section>

	
	<section class="content" style="float: left; margin-top: 47px; background: #fff">
	    <div class="row">
	    	<fieldset>
	    		<legend style="text-align: center;font-weight: 900;padding: 10px;">EDITAR CATEGORIAS DE ENCUESTAS <small></small></legend>
	    		<div class="box-header with-border">
					<p>{{-- categoria  {{ $encuesta->category }} --}}
						@if(session()->has('message'))
							<div class="alert alert-danger">
									{{ session()->get('message') }}
							</div>
						@endif
					</p>
	          	</div>
	    		@include('includes.messages')  
		        <form role="form" action="{{ route('categories.update', $category->id) }}" method="post">
		          	{{ csrf_field() }}
		           	{{ method_field('PUT') }}
					<input type="hidden" name="id" value="{{ $category->id }}">	
	            	<div class="col-md-6">
	            		<div class="form-group">
	                    	<label for="name">Nombre de la categoria</label>
		                	<input type="text" class="form-control" id="name" name="name" placeholder="Nombre de la categoria" value="{{$category->name}}">
		              	</div>
	            	</div>
	              	<div class="col-md-6">
	              		<div class="form-group">
	              			<label for="name">Tipo:</label>
		                   	<select name="timer_type" id="type" class="form-control" required>
			                 	<option value="1">Sin tiempo</option>
			                 	<option value="2">Tiempo por pregunta</option>
			                 	<option value="3">Tiempo por encuesta</option>
			              	</select>
			          	</div>
	              	</div>
	              	@if ($category->timer_type > 1)
		              	<div class="col-md-12 tiempo">
						    <div class="panel panel-primary">
				                <div class="panel-heading">
				                    <h3 class="panel-title">
				                        <i class="icon-time"></i>  Configuración de tiempo</h3>
				                </div>
				                <div class="panel-body">
				                    <div class="row">
				                        <div class="col-md-4">
						              		<div class="form-group" id="hour">
								                <label for="name">Horas</label>
								                <input type="text" class="form-control" class="hour" name="hour" placeholder="Hora" value="{{$category->hour}}">
							                </div>	
						              	</div>
						              	<div class="col-md-4">
						              		<div class="form-group" id="minutes">
								                <label for="name">Minutos</label>
								                <input type="text" class="form-control" class="minutes" name="minutes" placeholder="Minutos" value="{{$category->minutes}}">
							                </div>
						              	</div>	
					                  	<div class="col-md-4">
					                  		<div class="form-group" id="seconds">
								                <label for="name">Segundos</label>
								                <input type="text" class="form-control" class="seconds"  name="seconds" placeholder="Segundos" value="{{$category->seconds}}">
							                </div>
						              	</div>
				                    </div>
				                    
				                </div>
				            </div>
						</div>
					@endif
						<div class="col-md-4">
		               		<div class="form-group">
			  					<label for="slug">Activo</label>
			  					<br>
			  					@if ($category->status == 1)
			  						<input type="radio" name="status" id="status" value="1" checked="checked"> Si<br>
			  						<input type="radio" name="status" id="status" value="0"> No<br>
			  					@else
			  						<input type="radio" name="status" id="status" value="1"> Si<br>
			  						<input type="radio" name="status" id="status" value="0" checked="checked"> No<br>
			  					@endif
							</div>
		              	</div>

		              	<div class="col-md-4">
		               		<div class="form-group">
				                <label for="slug">Son obligatorias las respuestas?</label>
				                <br>
				                @if ($category->answer_required == 1)
							    	<input type="radio" name="answer_required" id="answer_required" value="1" checked="checked"> Si<br>
							    	<input type="radio" name="answer_required" id="answer_required" value="0"> No<br>
							    @else
							    	<input type="radio" name="answer_required" id="answer_required" value="1"> Si<br>
							    	<input type="radio" name="answer_required" id="answer_required" value="0" checked="checked"> No<br>
							    @endif<br>
				            </div>
		              	</div>	
		               	<div class="col-md-4">
		               		<div class="form-group">
				                <label for="slug">Mostrar todas las preguntas?</label>
				                <br>
				                @if ($category->show_all_questions == 1)
							    	<input type="radio" name="show_all_questions" id="show_all_questions" value="1" checked="checked"> Si<br>
							    	<input type="radio" name="show_all_questions" id="show_all_questions" value="0"> No<br>
							    @else
							    	<input type="radio" name="show_all_questions" id="show_all_questions" value="1"> Si<br>
							    	<input type="radio" name="show_all_questions" id="show_all_questions" value="0" checked="checked"> No<br>
							    @endif<br>
				            </div>
		              	</div>
		              	<div class="col-md-4">
		               		<div class="form-group" id="pausable">
				                <label for="slug">Es pausable la encuesta?</label>
				                <br>
				                @if ($category->pausable == 1)
				                	<input type="radio" name="pausable" value="1" checked="checked"> Si<br>
				                	<input type="radio" name="pausable" value="0"> No<br>
				                @else
				                	<input type="radio" name="pausable" value="1"> Si<br>
				                	<input type="radio" name="pausable" value="0" checked="checked"> No<br>
				                @endif
				            </div>
		              	</div>	
		               	<div class="col-md-12">
		               		<div style="margin-left: auto; margin-right: auto;     text-align: center;">
				                <button type="submit" class="btn btn-primary">Guardar</button>
				                <a href='{{ route('categories.index') }}' class="btn btn-warning">Regresar</a>
				            </div>
		              	</div>	
		        </form>
	    	</fieldset>
	    </div>
	    <br><br><br>
	</section>
	  
	</div>
	
@endsection
@section('footerSection')
	<style type="text/css">
		.panel-primary>.panel-heading {
		    color: #fff;
		    background-color: rgba(96, 92, 168, 0.62) !important;
		    border-color: #ecf0f5 !important;
		}
		.panel{
			border: 1px solid #ecf0f5 !important;
		}
	</style>

	
	
	<script>
	    $(function() {
	    	var timer_type = "{{$category->timer_type}}";
	    	$("#type").val(timer_type);
	    	$('#type').on('change',function () {
		        var var_type = $('#type').val();
		        console.log(var_type);  
		        if (var_type == 2 || var_type == 3) {
		        	$('.tiempo').css('display', "block");
		            $('#hour').show();
		            $('#minutes').show();
		            $('#seconds').show();
			    	$('#pausable').hide();
			    	$('.pausable').val(0);
				}

		        if (var_type == 1) {
		        	$('.tiempo').css('display', "none");
		            $('input[name="hour"]').val(0);
					$('input[name="minutes"]').val(0);
					$('input[name="seconds"]').val(0);
		    		$('#pausable').show();
		    		
				}       
	          
	        });  

		});
	</script>
@endsection