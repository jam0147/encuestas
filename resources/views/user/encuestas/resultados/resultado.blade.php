@extends('user.layouts.app2')
@section('content')
    <br>    <br>    <br>    <br>
    <!-- Service section -->
    <section id="service">
        <div class="container">
            <div class="row">
                <div class="sec-title text-center"><br>
                    <h2 class="wow animated bounceInLeft" style="color: #999999;">{{ $encuesta->name }}</h2>
                </div>
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <h3 class="text-center" style="color: #999999;">Ya tenemos tu calificacion.</h3>
                            <br>                             
                            <div class="table-responsive">          
                              <table class="table">
                                <thead>
                                  <tr>
                                    <th>Puntaje</th>
                                    <th>Resultado</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td>{{ $total }}</td>
                                    <td>
                                        @if (!$resume->text == null)
                                            {{ $resume->text }}
                                        @endif
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                        </div>
                    </div>
                </div>                
            </div>
        </div>
    </section>    
  
@endsection