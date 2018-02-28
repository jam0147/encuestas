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
     Rangos de Encuestas
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
          {{-- <div class="box-header">
            <h1>Encuestas <a href="{{ url('admin/polls/create') }}" class="btn btn-primary pull-right btn-sm">Crear Encuesta</a></h1>
          </div> --}}
          <!-- /.box-header -->
          <div class="box-body">
            @include('includes.messages')
            <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>ID</th><th>Nombre de la encuesta</th>{{-- <th>Categoria</th><th>Hora</th><th>Minutos</th><th>Segundos</th> --}}
              </tr>
              </thead>
              <tbody>
              @if (!empty($polls))
                @foreach ($polls as $item)
                  <tr>
                      <td>{{ $item->id }}</td>
                      <td>
                        <a href="{{ url('admin/ranges', $item->id ) }}">{{ $item->name }}</a>{{ $item->nif_cif }}
                      </td>
                      {{-- <td>{{ $item->category->name }}</td>
                      <td> 
                        {{ $item->hour }}
                      </td>
                      <td>  {{ $item->minutes }} </td>
                      <td> {{ $item->seconds }}</td> --}}
                      

                      
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
                                    
          

