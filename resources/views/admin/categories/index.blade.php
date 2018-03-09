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
     Categorias
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
                <div class="alert alert-danger">
                    {{ session()->get('message') }}
                </div>
              @endif
            </p>
            <h1> <a href="{{ url('admin/categories/create') }}" class="btn btn-primary pull-right btn-sm">Crear Categoria</a></h1>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table id="example1" class="table table-striped table-hover table-bordered dataTable">
              <thead>
              <tr>
                <th>ID</th><th>Nombre de la categoria</th><th>Tipo de tiempo</th><th>Es pausable</th><th>Preguntas obligatorias</th><th>Acciones</th>
              </tr>
              </thead>
              <tbody>
              @if (!empty($categories))
                @foreach ($categories as $item)
                  <tr>
                      <td>{{ $item->id }}</td>
                      <td>
                        <a href="{{ url('admin/categories/' . $item->id . '/edit') }}">{{ $item->name }}</a>{{ $item->nif_cif }}
                      </td>
                      
                      <td> 
                        @if ($item->timer_type == 1)
                          Sin tiempo
                        @elseif ($item->timer_type == 2)
                          Tiempo por pregunta
                        @elseif ($item->timer_type == 3)
                           Tiempo por encuesta
                        @endif
                      </td>

                      <td> 
                        @if ($item->pausable == 1)
                          Si
                        @else
                          No
                        @endif
                      </td>

                      <td> 
                        @if ($item->answer_required == 1)
                          Si
                        @else
                          No
                        @endif
                      </td>
                      

                      <td >
                          <a href="{{ url('admin/categories/' . $item->id . '/edit') }}" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i></a> 
                          <form action="{{ route('categories.destroy',  $item->id) }}" method="post" style="display:inline">
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
                                    
          

