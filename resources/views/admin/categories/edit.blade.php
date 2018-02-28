@extends('admin.layouts.app')

@section('main-content')
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
	  <!-- Content Header (Page header) -->
	  <section class="content-header">
	    <h1>
	      Editar Categoria
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
							<p>{{-- categoria  {{ $encuesta->category }} --}}
								@if(session()->has('message'))
									<div class="alert alert-danger">
											{{ session()->get('message') }}
									</div>
								@endif
							</p>
	          </div>
	    	@include('includes.messages')      
	          <!-- /.box-header -->
	          <!-- form start -->
	          <form role="form" action="{{ route('categories.update', $category->id) }}" method="post">
	          {{ csrf_field() }}
							{{ method_field('PUT') }}
							<input type="hidden" name="id" value="{{ $category->id }}">


	            <div class="box-body">
	            <div class="col-lg-offset-3 col-lg-4">
	              <div class="form-group">
	                <label for="name">Nombre de la categoria</label>
	                <input type="text" class="form-control" id="name" name="name" placeholder="Nombre de la categoria" value="{{$category->name}}">
	              </div>

                  <div class="form-group">
	                <label for="name">Horas</label>
	                <input type="text" class="form-control" id="hour" name="hour" placeholder="Hora" value="{{$category->hour}}">
                  </div>

                  <div class="form-group">
	                <label for="name">Minutos</label>
	                <input type="text" class="form-control" id="minutes" name="minutes" placeholder="Minutos" value="{{$category->minutes}}">
                  </div>

                  <div class="form-group">
	                <label for="name">Segundos</label>
	                <input type="text" class="form-control" id="seconds" name="seconds" placeholder="Segundos" value="{{$category->seconds}}">
                  </div>

	              <div class="form-group">
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

				  <div class="form-group">
				    <label for="slug">Son obligatorias las respuestas?</label>
				    <br>
				    @if ($category->answer_required == 1)
				    	<input type="radio" name="answer_required" id="answer_required" value="1" checked="checked"> Si<br>
				    	<input type="radio" name="answer_required" id="answer_required" value="0"> No<br>
				    @else
				    	<input type="radio" name="answer_required" id="answer_required" value="1"> Si<br>
				    	<input type="radio" name="answer_required" id="answer_required" value="0" checked="checked"> No<br>
				    @endif
				  </div>
					
					<div class="form-group">
						<label for="slug">Mostrar todas las preguntas?</label>
						<br>
						@if ($category->show_all_questions == 1)
				    	<input type="radio" name="show_all_questions" id="show_all_questions" value="1" checked="checked"> Si<br>
				    	<input type="radio" name="show_all_questions" id="show_all_questions" value="0"> No<br>
				    @else
				    	<input type="radio" name="show_all_questions" id="show_all_questions" value="1"> Si<br>
				    	<input type="radio" name="show_all_questions" id="show_all_questions" value="0" checked="checked"> No<br>
				    @endif
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