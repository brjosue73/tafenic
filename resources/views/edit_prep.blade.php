<!--************************************************************************************
                              Vista: Registro de Preplanilla Diaria
****************************************************************************************-->
@extends('home')
@section('content')


<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 full_h view_body">
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 tarjeta blanco m-top_dow">
    <h1>Modificar Registro de Preplanilla - {{$trab->nombre}} {{$trab->apellidos}}  </h1>

    <form id="prepResetForm" class="col-lg-12 col-md-12 col-sm-12" method="POST" action="/preplanillass/{{$data->id}}">

      <div class="form-group col-sm-2 col-md-2 col-lg-2">
        <label for="finca">Finca:</label>
        <select name="id_finca" id="fincaSelect" class="form-control">
            <option value="{{$data->id_finca}}" Selected>{{$finc->nombre}}</option>
        </select>
      </div>

      <div class="form-group col-md-2 col-sm-2 col-lg-2">
        <label for="centroCosto">Centro de Costos: </label>
        <select name="centro_costo" class="form-control" >
          <option value="{{$data->centro_costo}}">{{$centro[$data->centro_costo]}}</option>
          <option value="0">Tabaco Sol</option>
          <option value="1">Tabaco Tapado</option>
          <option value="2">Semillero</option>
          <option value="3">Ensarte</option>
          <option value="4">Safadura</option>
        </select>
      </div>

      <div class="form-group col-sm-2 col-md-2 col-lg-2">
        <label for="lotes">Lote:</label>
        <select name="id_lote" id="lotes" class="form-control" >
          <optgroup label="Lotes">
            <option  value="{{$data->id_lote}}">{{$lote->lote}}</option>
          </optgroup>
        </select>
      </div>

      <div class="form-group col-sm-2 col-md-2 col-lg-2">
        <label for="">fecha: </label>
        <input name="fecha" type="date" class="form-control" value="{{$data->fecha}}">
      </div>

      <div class="form-group col-sm-2 col-md-2 col-lg-2">
        <label for="listero">Listero:</label>
        <select name="id_listero" id="lsiteroSelect" class="form-control">
          <optgroup label="trabajadores">
            <option value="{{$data->id_listero}}">{{$listero->nombre}} {{$listero->apellidos}}</option>
          </optgroup>
        </select>
      </div>

      <div class="form-group col-sm-2 col-md-2 col-lg-2">
        <label for="responsable">Resp. de finca:</label>
        <select name="id_respFinca" id="respFSelect" class="form-control">
          <optgroup label="trabajadores">
            <option value="{{$data->id_respFinca}}">{{$resp_finc->nombre}} {{$resp_finc->apellidos}}</option>
          </optgroup>
        </select>
      </div>

      <div class="form-group col-sm-2 col-md-2 col-lg-2">
        <label for="feriado">Feriado: </label><br>
        @if ($data->tipo_feriado==0)
        <label for="">Trabajado  </label><input type="radio" name="feriados" value="1" >
        <label for="">No trab.  </label><input type="radio" name="feriados" value="0" >
        @elseif ($data->tipo_feriado==1)
        <label for="">Trabajado  </label><input type="radio" name="feriados" value="1" >
        <label for="">No trab.  </label><input type="radio" name="feriados" value="0" Selected >
        @elseif ($data->tipo_feriado==2)
        <label for="">Trabajado  </label><input type="radio" name="feriados" value="1" Selected>
        <label for="">No trab.  </label><input type="radio" name="feriados" value="0"  >
        @endif
      </div>

      <hr class="col-sm-11 col-md-11 col-lg-11" style="background-color: black">

      <div class="form-group col-sm-4 col-md-4 col-lg-4">
        <label for="">Trabajador: </label>
        <select name="id_trabajador" id="trabajadorSelect" class="form-control" >
          <optgroup label="trabajadores">
            <option selected value={{$trab['id']}}>{{$trab->nombre}} {{$trab->apellidos}}</option>
          </optgroup>
        </select>
      </div>

      <div class="form-group col-sm-4 col-md-4 col-lg-4">
        <label for="actividad">Actividad:</label>
        <select name="id_actividad" id="actividadSelect" class="form-control" >
          <optgroup label="Actividades">
            <option selected value="{{$actividad->id}}" >{{$actividad->nombre}}</option>
          </optgroup>
        </select>
      </div>

      <div class="form-group col-sm-4 col-md-4 col-lg-4">
        <label for="labor" >Labor:</label>
        <select name="id_labor" id="laborSelect" class="form-control" >
          <optgroup label="Labores">
            <option selected value="{{$labor->id}}" >{{$labor->nombre}}</option>
          </optgroup>
        </select>
      </div>

      <div class="form-group col-sm-4 col-md-4 col-lg-4">
        <label for="">horas trabajadas: </label>
        <input name="hora_trab" type="text" class="form-control" value={{$data->hora_trab}}>
      </div>

      <div class="form-group col-sm-4 col-md-4 col-lg-4" >
        <label for="">horas extra: </label>
        <input name="hora_ext" type="text" class="form-control" value="{{$data->hora_ext}}">
      </div>

      <div class="form-group col-sm-4 col-md-4 col-lg-4">
        <label for="" class="control-label">Tamaño de cuje: </label>
        <select name="tamano_cuje" class="form-control" >
          <option selected value="{{$tamano_cuje['id']}}" >{{$tamano_cuje['name']}}</option>
          <option value="0">Pequeño</option>
          <option value="1">Grande</option>
        </select>
      </div>

      <div class="form-group col-sm-4 col-md-4 col-lg-4">
        <label for="" class="label-control">Cant. Cujes:</label>
        <input type="text" name='cant_cujes' class="form-control" value="{{$data->cant_cujes}}">
      </div>

      <div class="form-group col-sm-4 col-md-4 col-lg-4">
        <label for="">Cujes Extras: </label>
        <input name="cuje_ext" type="text" class="form-control" value="{{$data->cuje_ext}}">
      </div>

      <div class="form-group col-sm-4 col-md-4 col-lg-4">
        <label for="" class="control-label">Tamaño de Safadura: </label>
        <select class="form-control">
          <option selected value="{{$tamano_safa['id']}}" >{{$tamano_safa['name']}}</option>
          <option value="0">Pequeño</option>
          <option value="1">Grande</option>
        </select>
      </div>

      <div class="form-group col-sm-4 col-md-4 col-lg-4">
        <label for="" class="label-control">Cant. Safa:</label>
        <input name="cant_safa" type="text" class="form-control" value="{{$data->cant_safa}}">

      </div>

      <div class="form-group col-sm-4 col-md-4 col-lg-4">
        <label for="">Safadura Extras: </label>
        <input name="safa_ext" type="text" class="form-control" value="{{$data->safa_ext}}">
      </div>

      <div class="form-group col-sm-4 col-md-4 col-lg-4">
        <label for="">Otros: </label>
        <input name="otros" type="text" class="form-control clean" value="{{$data->otros}}">
      </div>

      <div class="form-group col-sm-4 col-md-4 col-lg-4">
        <label for="">Préstamos: </label>
        <input name="prestamos" type="text" class="form-control" value="{{$data->prestamo}}">
      </div>

      <div class="form-group col-sm-4 col-md-4 col-lg-4">
        <label for="">Séptimo: </label>
        <input name="septimo" type="text" class="form-control" value="{{$data->septimos}}">
      </div>

      <div class="form-group col-sm-1 col-md-1 col-lg-1">
        <label class="control-label">Subsidio: </label>
        <input name="subsidios" id="chkSub" type="checkbox" class="form-control">
      </div>

      <div class="form-group col-sm-4 col-md-4 col-lg-4">
        <input type="submit" class="btn btn-primary" value="Modificar">
      </div>

    </form>
  </div>
</div>

@endsection
