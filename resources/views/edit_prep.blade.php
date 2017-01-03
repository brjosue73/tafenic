<!--************************************************************************************
                              Vista: Registro de Preplanilla Diaria
****************************************************************************************-->
@extends('home')
@section('content')


<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 full_h view_body" data-ui-view>
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 tarjeta blanco m-top_dow">
    <h1>Modificar Registro de Preplanilla - {{$trab->nombre}} {{$trab->apellidos}}  </h1>
    <form id="clean"></form>
    <form id="prepResetForm" class="col-lg-12 col-md-12 col-sm-12">
      <div class="form-group col-sm-2 col-md-2 col-lg-2">
        <label for="finca">Finca:</label>
        <select name="finca" id="fincaSelect" class="form-control">
            <option Selected value="{{$data->id_finca}}">{{$finc->nombre}}</option>
        </select>
      </div>
      <div class="form-group col-md-2 col-sm-2 col-lg-2">
        <label for="centroCosto">Centro de Costos: </label>
        <select name="centroCosto" class="form-control" >
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
        <select name="lotes" id="lotes" class="form-control" >
          <optgroup label="Lotes">
            <option  value="{{$data->id_lote}}">{{$lote->lote}}</option>
          </optgroup>
        </select>
      </div>

      <div class="form-group col-sm-2 col-md-2 col-lg-2">
        <label for="">fecha: </label>
        <input type="date" class="form-control" value="{{$data->fecha}}">
      </div>
      <div class="form-group col-sm-2 col-md-2 col-lg-2">
        <label for="listero">Listero:</label>
        <select name="listero" id="lsiteroSelect" class="form-control">
          <optgroup label="trabajadores">
            <option value="{{$data->id_listero}}">{{$listero->nombre}} {{$listero->apellidos}}</option>
          </optgroup>
        </select>
      </div>
      <div class="form-group col-sm-2 col-md-2 col-lg-2">
        <label for="responsable">Resp. de finca:</label>
        <select name="responsable" id="respFSelect" class="form-control">
          <optgroup label="trabajadores">
            <option value="{{$data->id_respFinca}}">{{$resp_finc->nombre}} {{$resp_finc->apellidos}}</option>
          </optgroup>
        </select>
      </div>
      <div class="form-group col-sm-2 col-md-2 col-lg-2">
        <label for="feriado">Feriado: </label><br>
        @if ($data->tipo_feriado==0)
        <label for="">Trabajado  </label><input type="radio" name="feriado" value="1" >
        <label for="">No trab.  </label><input type="radio" name="feriado" value="0" >
        @elseif ($data->tipo_feriado==1)
        <label for="">Trabajado  </label><input type="radio" name="feriado" value="1" >
        <label for="">No trab.  </label><input type="radio" name="feriado" value="0" Selected >
        @elseif ($data->tipo_feriado==2)
        <label for="">Trabajado  </label><input type="radio" name="feriado" value="1" Selected>
        <label for="">No trab.  </label><input type="radio" name="feriado" value="0"  >
        @endif

      </div>

      <hr class="col-sm-11 col-md-11 col-lg-11" style="background-color: black">

      <div class="form-group col-sm-4 col-md-4 col-lg-4">
        <label for="">Trabajador: </label>

        <select form="clean" name="trabajador" id="trabajadorSelect" class="form-control" >
          <optgroup label="trabajadores">
            <option selected value={{$trab['id']}}>{{$trab->nombre}} {{$trab->apellidos}}</option>
          </optgroup>
        </select>
      </div>
      <div class="form-group col-sm-4 col-md-4 col-lg-4">
        <label for="actividad">Actividad:</label>
        <select name="actividad" id="actividadSelect" class="form-control" >
          <optgroup label="Actividades">
            <option selected value="{{$actividad->id}}" >{{$actividad->nombre}}</option>
          </optgroup>
        </select>
      </div>
      <div class="form-group col-sm-4 col-md-4 col-lg-4">
        <label for="labor" >Labor:</label>
        <select name="labor" id="laborSelect" class="form-control" >
          <optgroup label="Labores" data-ng-controller="preplanilla">
            <option selected value="{{$labor->id}}" >{{$labor->nombre}}</option>
          </optgroup>
        </select>
      </div>
      <!--<div class="form-group col-sm-1 col-md-1 col-lg-1">
        <label for="tipoLabor">Tipo Prod</label>
        <input type="checkbox" class="form-control" data-ng-model="labValue">
      </div>-->
      <div class="form-group col-sm-4 col-md-4 col-lg-4">
        <label for="">horas trabajadas: </label>
        <input form="clean" type="text" class="form-control" value={{$data->hora_trab}}>
      </div>
      <div class="form-group col-sm-4 col-md-4 col-lg-4" >
        <label for="">horas extra: </label>
        <input form="clean" type="text" class="form-control" data-ng-model="prepSendData.hora_ext" value="{{$data->hora_ext}}">
      </div>
      <div class="form-group col-sm-4 col-md-4 col-lg-4">
        <label for="" class="control-label">Tamaño de cuje: </label>
        <select form="clean" class="form-control" data-ng-model="prepSendData.tamano_cuje">
          <option value="">Seleccionar</option>
          <option value="0">Pequeño</option>
          <option value="1">Grande</option>
        </select>
      </div>
      <div class="form-group col-sm-4 col-md-4 col-lg-4">
        <label for="" class="label-control">Cant. Cujes:</label>
        <input form="clean" type="text" class="form-control" data-ng-model="prepSendData.cant_cujes">
      </div>
      <div class="form-group col-sm-4 col-md-4 col-lg-4">
        <label for="">Cujes Extras: </label>
        <input form="clean" type="text" class="form-control" data-ng-model="prepSendData.cuje_ext">
      </div>
      <div class="form-group col-sm-4 col-md-4 col-lg-4">
        <label for="" class="control-label">Tamaño de Safadura: </label>
        <select form="clean" class="form-control" data-ng-model="prepSendData.tamano_safa">
          <option value="">Seleccionar</option>
          <option value="0">Pequeño</option>
          <option value="1">Grande</option>
        </select>
      </div>
      <div class="form-group col-sm-4 col-md-4 col-lg-4">
        <label for="" class="label-control">Cant. Safa:</label>
        <input form="clean" type="text" class="form-control" data-ng-model="prepSendData.cant_safa">
      </div>
      <div class="form-group col-sm-4 col-md-4 col-lg-4">
        <label for="">Safadura Extras: </label>
        <input form="clean" type="text" class="form-control" data-ng-model="prepSendData.safa_ext">
      </div>
      <div class="form-group col-sm-4 col-md-4 col-lg-4">
        <label for="">Otros: </label>
        <input form="clean" type="text" class="form-control clean" value="{{$data->otros}}">
      </div>
      <div class="form-group col-sm-4 col-md-4 col-lg-4">
        <label for="">Préstamos: </label>
        <input form="clean" type="text" class="form-control" value="{{$data->prestamo}}">
      </div>
      <div class="form-group col-sm-4 col-md-4 col-lg-4">
        <label for="">Séptimo: </label>
        <input form="clean" type="text" class="form-control" value="{{$data->septimos}}">
      </div>
      <div class="form-group col-sm-1 col-md-1 col-lg-1">
        <label class="control-label">Subsidio: </label>
        @if($data->subsidios==0)
        <input id="chkSub" type="checkbox" class="form-control"><!-- data-ng-model="prepSendData.subsidio"-->
        @else
        <input id="chkSub" type="checkbox" class="form-control" checked><!-- data-ng-model="prepSendData.subsidio"-->
        @endif
      </div>

      <div class="form-group col-sm-4 col-md-4 col-lg-4">
        <br>
        <button id="save-preplanilla" class="btn btn-primary" data-ng-click="prepTrab()">Guardar</button>
        <i id="prepSpinner" class="fa fa-spinner fa-pulse fa-lg" style="color:blue; display:none;"></i>
        <span id="exitoprep" style="color:green; display:none;">Guardado! <i class="fa fa-check-circle fa-lg"></i></span>
        <span id="errorprep" style="color:Red; display:none;">Error: vuelve a intentarlo <i class="fa fa-times-circle fa-lg"></i></span>
      </div>
    </form>
  </div>
</div>

<!--************************************************************************************
                                VALORES MODAL END
****************************************************************************************-->

@endsection
