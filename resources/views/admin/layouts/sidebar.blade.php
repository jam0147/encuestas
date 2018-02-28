<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ asset('admin/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          {{-- <p>Usuario:</p> --}}
          <div>{{Auth::user()->name}} </div>
          <p>{{-- {{Auth::user()->email}}  --}}</p>
        </div>
      </div>
    
      <ul class="sidebar-menu">
        <li class="header">Opciones {{-- {{Auth::user()->id}} --}}</li>
        <li class="active treeview">
          <li class=""><a href="{{ route('admins.index') }}"><i class="fa fa-circle-o"></i> Administradores</a></li>

          <li class=""><a href="{{ route('categories.index') }}"><i class="fa fa-circle-o"></i> Categorias</a></li>
          <li class=""><a href="{{ route('polls.index') }}"><i class="fa fa-circle-o"></i> Encuestas</a></li>
          <li class=""><a href="{{ route('ranges.index') }}"><i class="fa fa-circle-o"></i> Establecer Rangos</a></li>
          <li class=""><a href="{{ route('user.index') }}"><i class="fa fa-circle-o"></i>index</a></li>
          <li class=""><a href="{{ route('admin.logout') }}"
                          onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">
            <i class="fa fa-circle-o"></i>Salir</a></li>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              {{ csrf_field() }}
          </form>

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>