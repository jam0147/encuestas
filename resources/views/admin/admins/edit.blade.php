@extends('admin.layouts.app')

@section('main-content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Crear usuario
      <small>Administradpor, Agente, Vendedor</small>
    </h1>
     @include('includes.messages')
    
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
      
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Datos</h3>
          </div>
          <!-- /.box-header -->
          
          <!-- form start -->
          <form role="form" action="{{ route('user.update', $user->id) }}" method="post" >
            {{ csrf_field() }}
            {{ method_field('PATCH') }}
            <div class="box-body">
            <div class="col-lg-6">
              <div class="form-group">
                <label for="title">nombre</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="name"  value="{{ $user->name }}" >
              </div>

              <div class="form-group">
                <label for="subtitle">email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="email" required value="{{ $user->email }}">
              </div>

              <div class="form-group">
                <label for="slug">password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="password" required>
              </div>

              <div class="form-group">
                <label for="slug">confirmar password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="password" required>
              </div>
            	
            </div>
			<div class="col-lg-6">
          <div class="form-group">
            <label for="subtitle">Telefono</label>
            <input type="phone" class="form-control" id="phone" name="phone" placeholder="Telefono"  value="{{ $user->phone }}" required>
          </div>    
				<br>
              <div class="form-group">
                  <label for="form-group">Activo</label>
                  <br>
                  <input type="radio" name="status" value="1"> Si<br>
                  <input type="radio" name="status" value="0"> No<br>
                </label>
              </div>
              <br>
              <div class="form-group">
                <label for="cargo">Cargo</label>
                <br>
                <input type="hidden" name="level" value="{{$user->level}}">
                @if($user->level ==1)
                  <p>Administrador</p>
                @endif
                @if($user->level == 2 )
                  <p>Delegado</p>
                @endif 
                @if($user->level == 3 )
                  <p>Agente</p>
                @endif
              </div>
				
			</div>


      <div class="col-lg-6">
        
        <div class="form-group">
          <label for="subtitle">Provincia</label>
          <input type="state" class="form-control" id="state" name="state" placeholder="Provincia"  value="{{ $user->state }}" required>
        </div>

        <div class="form-group">
          <label for="subtitle">Ciudad</label>
          <input type="city" class="form-control" id="city" name="city" placeholder="Ciudad"  value="{{ $user->city }}" required>
        </div>

        <div class="form-group">
          <label for="subtitle">Direccion</label>
          <input type="address" class="form-control" id="address" name="address" placeholder="Direccion"  value="{{ $user->address }}}" required>
        </div>

      </div>
      
            </div>
            <!-- /.box-body -->
			
		

            <div class="box-footer">
              <button type="submit" class="btn btn-primary">Grabar</button>
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