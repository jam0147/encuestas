@extends('admin.layouts.app')

@section('headSection')
  <link rel="stylesheet" href="{{ asset('admin/plugins/datatables/dataTables.bootstrap.css') }}">
@endsection

@section('main-content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
     Encuestas
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
            <p>{{-- categoria  {{ $encuesta->category }} --}}
              @if(session()->has('message'))
                <div class="alert alert-info">
                    {{ session()->get('message') }}
                </div>
              @endif
            </p>
            <h1> <a href="{{ url('admin/polls/create') }}" class="btn btn-primary pull-right btn-sm">Crear Encuesta</a></h1>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            @include('includes.messages')
            <table id="example1" class="table table-striped table-hover table-bordered dataTable">
              <thead>
              <tr>
                <th>ID</th><th>Nombre de la encuesta</th><th>Mostrar todas las preguntas?</th><th>Categoria</th><th>Acciones</th>
              </tr>
              </thead>
              <tbody>
              @if (!empty($polls))
                @foreach ($polls as $item)
                  <tr>
                      <td>{{ $item->id }}</td>
                      <td>
                        <a href="{{ url('admin/polls/' . $item->id . '/edit') }}">{{ $item->name }}</a>
                      </td>
                      <td>
                        @if ($item->show_all_questions == 1)
                          Si
                        @elseif ($item->show_all_questions == 0)
                           No
                        @endif
                      </td>

                      <td>{{ $item->category->name }}</td>

                      <td>
                          <a href="{{ url('admin/polls/' . $item->id . '/edit') }}" class="btn btn-primary btn-xs">
                            <i class="fa fa-eye"></i>
                          </a>                            
                          <form action="{{ route('polls.destroy',  $item->id) }}" method="post" style="display:inline">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            
                            <button type="submit" alt="Eliminar"  class="btn btn-danger btn-xs" onclick="return confirm('Esta seguro de eliminar?');">
                              <i class="fa fa-minus"></i>
                            </button>
                          </form>
                      </td>
                    </tr>
                @endforeach
              @endif
              </tbody>
             
            </table>
          </div>
          <!-- /.box-body -->
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
<!-- /.content-wrapper -->
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
  });
</script>
@endsection
                                    
          

