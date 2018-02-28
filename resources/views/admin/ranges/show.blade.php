@extends('admin.layouts.app')

@section('headSection')
<link rel="stylesheet" href="{{ asset('admin/plugins/datatables/dataTables.bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('admin/css/font-awesome.min.css') }}">
{{--  <link rel="stylesheet" href="{{ url('https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css') }}">  --}}
{{-- <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous"> --}}
@endsection

@section('main-content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
     Rangos de: {{ $poll->name }}
    </h1>   
  </section>
  <!-- Main content -->
  <section class="content">
    <!-- Default box -->
    <div class="box">
      <div class="box-header with-border">
      </div>
      <div class="box-body">
        <div class="box">
          <div class="box-header">            
            <div class="form-group row add">
                <div class="col-md-8">
                	{{ csrf_field() }}                  
                  <a href="#" id="addRange" data-toggle="modal" data-target="#addRangeModal" 
                  class="" data-toggle="tooltip" title="Añdir pregunta!"><i class="fa fa-plus" aria-hidden="true" class="pull-right"></i></a>
                </div>                
            </div>
          </div> 
            <div id="myDiv">
        		@if (!empty($poll->ranges))
              <div class="box-body">
                <table class="table table-bordered">
                  <thead>
                   <tr >                 
                     <th class="question" >Desde</th>
                     <th>Hasta </th>
                     <th>Observacion</th>    
                   </tr>                
                  </thead>
                   @foreach($poll->ranges as $item)
                    <tbody>
                      <input type="hidden" id="range_id" value="{{ $item->id }}">

                      <td class="range" name="@php
                        echo "from".$item->id ;
                      @endphp"  id="{{ $item->id }}" data-toggle="modal" data-target="#addRangeModal" value="{{ $item->from }}">{{ $item->from }} </td>
                      <td class="range" name="@php
                        echo "to".$item->id ;
                      @endphp  id="{{ $item->id }}" data-toggle="modal" data-target="#addRangeModal">{{ $item->to }} </td>
                      <td class="range" name="@php
                        echo "text".$item->id ;
                      @endphp  id="{{ $item->id }}" data-toggle="modal" data-target="#addRangeModal">{{ $item->text }} </td>
                    </tbody>                    
           		     @endforeach
                </table>
              </div>
               <!-- /.box-body -->  
    	      @endif
            </div>
        </div>
        </div>
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
      </div>
      <!-- /.box-footer-->
    </div>
    <!-- /.box --> 
  </section>
  <!-- /.content -->
</div>

{{-- Range modal --}}
<div class="modal fade" id="addRangeModal" tabindex="-1" role="dialog">
 <div class="modal-dialog" role="document">
   <div class="modal-content">
     <div class="modal-header">
       <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
       <h4 class="modal-title" id="title">Añadir Rango</h4>
     </div>
     <div class="modal-body">
       <input type="number" min="1" id="from" name="from" placeholder="Desde" class="form-control">
       <input type="number" min="1" id="to" name="to" placeholder="Hasta" class="form-control">
       <input type="text" id="text" name="text" placeholder="Observacion" class="form-control">
       <input type="hidden" id="id">
     </div>
     <div class="modal-footer">
       {{-- <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span></button> --}}
       <button type="button" id="delete" style="display: none" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-trash"></span></button>
       <button type="button" id="saveChanges" style="display: none" class="btn btn-primary" data-dismiss="modal"><span class="glyphicon glyphicon-floppy-disk"></span></button>
       <button type="button" id="add" style="display: none" class="btn btn-primary" data-dismiss="modal"><span class="glyphicon glyphicon-floppy-disk"></span></button>
     </div>
   </div><!-- /.modal-content -->
 </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@endsection
@section('footerSection')
<script src="{{ asset('admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<script>	

$(function () {
	/*$("#example1").DataTable();*/
	$("#example1").DataTable( {
	  "pageLength": 100
	});
  console.log("pagina para editar los rangos");
  
  var url = '{{ route('ranges.store') }}';
  var url_delete = '{{ route('ranges.destroy', $poll->id) }}';
  var url_update = '{{ route('ranges.update', $poll->id) }}';
  var poll_id = {{ $poll->id }}
  
 /* $('.range').click(function(){
    console.log("se clickeo un rango");
  });*/


  //Modal Añadir pregunta
  $(document).on('click', '#addRange', function(event) {
    console.log('modal añadir');
    $('#from').val('');
    $('#to').val('');
    $('#text').val('');
    $('#add').show('400'); 
    $('#title').text('Añadir Rango');
    $('#delete').hide('400');
    $('#saveChanges').hide('400');
  
  });

  //Crear
  $('#add').click(function(event){
    var from = $('#from').val();
    var to = $('#to').val();
    var text = $('#text').val();

    console.log("desde: " + from);
    console.log("hasta: " + to);
    console.log("text: " + text);

    console.log("id  de la poll: " + poll_id);
    $.post(url, 
      {
        'from' : from, 
        'to' : to, 
        'text' : text, 
        'poll_id' : poll_id,         
        '_token' : $('input[name=_token]').val() }, function(data) {      
        $('#from').val('');
        $('#to').val('');
        $('#text').val('');        
        $('#myDiv').load(location.href + ' #myDiv' );
    });
  }); 

  //Editar rango
  $(document).on('click', '.range', function(event) {
    //Modal editar una pregunta
      console.log('editar rango');
      var id = $(this).find('#range_id').val();
      var range_id = $(this).attr('id');
      var from = $("input[name='from"+range_id+"']").val(); 
     
      console.log( "datos: " + from + to +text);
      
      $('#title').text('Editar Rango');
      $('#delete').show('400');
      $('#saveChanges').show('400');
      $('#add').hide('400'); 
      $('#id').val(); 
      console.log("id de rango: "  + range_id + id);
  }); 
    

});
</script>
<script src="{{ asset('admin/custom/question/answer.js') }}"></script>

@endsection
