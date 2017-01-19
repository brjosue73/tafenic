@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Register</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/registrar') }}">
                          {{ csrf_field() }}
                          <div class="form-group">
                              <label class="col-md-4 control-label">Nombre</label>

                              <div class="col-md-6">
                                  <input type="text" class="form-control" name="name">
                              </div>
                          </div>

                          <div class="form-group">
                              <label class="col-md-4 control-label">Correo</label>

                              <div class="col-md-6">
                                  <input type="email" class="form-control" name="email">
                              </div>
                          </div>

                          <div class="form-group">
                              <label class="col-md-4 control-label">Contraseña</label>

                              <div class="col-md-6">
                                  <input type="password" class="form-control" name="password">
                              </div>
                          </div>

                          <div class="form-group">
                              <label class="col-md-4 control-label">Confirmar Contraseña</label>

                              <div class="col-md-6">
                                  <input type="password" class="form-control" name="password_confirmation">
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-md-4 control-label">Tipo de Usuario</label>
                              <div class="col-md-6">
                                <select name="type_user" class="form-control" >
                                  <option value="0">Usuario</option>
                                  <option value="1">Administrador</option>
                                  <!-- <option value="2">Super Administrador</option> -->
                                </select>
                              </div>
                          </div>


                          <div class="form-group">
                              <div class="col-md-6 col-md-offset-4">
                                  <button type="submit" class="btn btn-primary">
                                      <i class="fa fa-btn fa-user"></i>Register
                                  </button>
                              </div>
                          </div>
                      </form>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
