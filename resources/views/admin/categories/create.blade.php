@extends('admin.layouts.app')

@section('main-content')
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
	  <!-- Content Header (Page header) -->
	  <section class="content-header">
	    <h1>
	      Categorias
	      <small>para las encuestas</small>
	    </h1>
	    <ol class="breadcrumb">
	      <li><a href="{{ route('categories.index') }}"><i class="fa fa-dashboard"></i> Index</a></li>
	    </ol>
	  </section>

	  <!-- Main content -->
	  <section class="content">
	    <div class="row">
	      <div class="col-md-12">
	        <!-- general form elements -->
	        <div class="box box-primary">
	          <div class="box-header with-border">
	          </div>
	    	@include('includes.messages')  
	          <form role="form" action="{{ route('categories.store') }}" method="post">
	          {{ csrf_field() }}
	            <div class="box-body">
	            <div class="col-lg-offset-3 col-lg-4">
	              <div class="form-group">
                    <label for="name">Nombre de la categoria</label>
	                <input type="text" class="form-control" id="name" name="name" placeholder="Nombre de la categoria">
	              </div>
                  
	               <div class="form-group">
	                   <select name="timer_type" id="type" required>
		                 <option value="1">Sin tiempo</option>
		                 <option value="2">Tiempo por pregunta</option>
		                 <option value="3">Tiempo por encuesta</option>
		              </select>
		          </div>

                  <div class="form-group" id="hour">
	                <label for="name">Horas</label>
	                <input type="text" class="form-control" class="hour" name="hour" placeholder="Hora">
                  </div>

                  <div class="form-group" id="minutes">
	                <label for="name">Minutos</label>
	                <input type="text" class="form-control" class="minutes" name="minutes" placeholder="Minutos">
                  </div>

                  <div class="form-group" id="seconds">
	                <label for="name">Segundos</label>
	                <input type="text" class="form-control" class="seconds"  name="seconds" placeholder="Segundos">
                  </div>

	              <div class="form-group" id="pausable">
	                <label for="slug">Es pausable la encuesta?</label>
	                <br>
	                <input type="radio" name="pausable" class="pausable" value="1" checked="checked" > Si<br>
	                <input type="radio" name="pausable" class="pausable" value="0"> No<br>
	              </div>

	              <div class="form-group">
	                <label for="slug">Son obligatorias las respuestas?</label>
	                <br>
	                <input type="radio" name="answer_required" value="1" checked="checked" > Si<br>
	                <input type="radio" name="answer_required" value="0"> No<br>
	              </div>
	              
								<div class="form-group">
	                <label for="slug">Mostrar todas las preguntas?</label>
	                <br>
	                <input type="radio" name="show_all_questions" value="1" checked="checked" > Si<br>
	                <input type="radio" name="show_all_questions" value="0"> No<br>
	              </div>

	              <div class="form-group">
	                <button type="submit" class="btn btn-primary">Guardar</button>
	                <a href='{{ route('categories.index') }}' class="btn btn-warning">Regresar</a>
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
	  </section>
	  <!-- /.content -->
	</div>
	<!-- /.content-wrapper -->
@endsection

@section('footerSection')
	
	
	<script>
	    $(function() {
	    	$('#hour').hide();
	    	$('#minutes').hide();
	    	$('#seconds').hide();

			console.log( "testing categories 1.0" );   
			$('#type').on('change',function () {
		          var var_type = $('#type').val();
		          console.log(var_type);  
		          if (var_type == 2 || var_type == 3) {
		            $('#hour').show();
		            $('#minutes').show();
		            $('#seconds').show();
			    			$('#pausable').hide();
			    			$('.pausable').val(0);
								
		          }

		          if (var_type == 1) {
		            $('#hour').hide();
								$('#minutes').hide();
								$('#seconds').hide();
			    			$('#pausable').show();
			    			$('.hour').val(0);
			    			$('.minutes').val(0);
			    			$('.seconds').val(0);
								
								
		          }       
	          
	        });  

		});
	</script>
@endsection