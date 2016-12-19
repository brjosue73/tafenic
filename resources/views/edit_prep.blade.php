<!--************************************************************************************
                              Vista: Registro de Preplanilla Diaria
****************************************************************************************-->
@extends('home')
@section('content')

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 full_h view_body" data-ui-view>
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 tarjeta blanco m-top_dow">
    <h1>Modificar Registro de Preplanilla</h1>
    <form id="clean"></form>
    <form id="prepResetForm" class="col-lg-12 col-md-12 col-sm-12">
      <div class="form-group col-sm-3 col-md-3 col-lg-3">
        <label for="finca"><% soprano %></label>
        <select name="finca" id="fincaSelect" class="form-control" data-ng-model="prepSendData.id_finca" data-ng-change="getActividades()" data-ng-init="soprano = prepReg.aguinaldo ">
          <optgroup label="Fincas">
            <option data-ng-repeat="finca in lasfincas" value="<% finca.id %>"><% finca.nombre %></option>
          </optgroup>
        </select>
      </div>
      <div class="form-group col-sm-3 col-md-3 col-lg-3">
        <label for="lotes">Lote:</label>
        <select form="clean" name="lotes" id="lotes" class="form-control" data-ng-model="prepSendData.id_lote">
          <optgroup label="Lotes">
            <option data-ng-repeat="lotes in loslotes" value="<% lotes.id %>"><% lotes.lote %></option>
          </optgroup>
        </select>
      </div>
      <!-- <div class="form-group col-sm-2 col-md-2 col-lg-2">
        <label for="">Lote: </label>
        <input form="clean" type="text" class="form-control clean" data-ng-model="prepSendData.id_lote">
      </div> -->
      <div class="form-group col-sm-2 col-md-2 col-lg-2">
        <label for="">fecha: </label>
        <input type="date" class="form-control" data-ng-model="prepSendData.fecha">
      </div>
      <div class="form-group col-sm-2 col-md-2 col-lg-2">
        <label for="listero">Listero:</label>
        <select name="listero" id="lsiteroSelect" class="form-control" data-ng-model="prepSendData.id_listero">
          <optgroup label="trabajadores">
            <option data-ng-repeat="trabajador in trabListero" value="<% trabajador.id %>"><% trabajador.nombre %></option>
          </optgroup>
        </select>
      </div>
      <div class="form-group col-sm-2 col-md-2 col-lg-2">
        <label for="responsable">Resp. de finca:</label>
        <select name="responsable" id="respFSelect" class="form-control" data-ng-model="prepSendData.id_respFinca">
          <optgroup label="trabajadores">
            <option data-ng-repeat="trabajador in trabRespFinc" value="<% trabajador.id %>"><% trabajador.nombre %></option>
          </optgroup>
        </select>
      </div>
      <div class="form-group col-sm-2 col-md-2 col-lg-2">
        <label for="feriado">Feriado: </label><br>
        <label for="">Trabajado  </label><input type="radio" name="feriado" value="1" data-ng-model="prepSendData.feriado">
        <label for="">No trab.  </label><input type="radio" name="feriado" value="0" data-ng-model="prepSendData.feriado">
      </div>

      <hr class="col-sm-11 col-md-11 col-lg-11" style="background-color: black">

      <div class="form-group col-sm-4 col-md-4 col-lg-4">
        <label for="">Trabajador: </label>
        <select form="clean" name="trabajador" id="trabajadorSelect" class="form-control" data-ng-model="prepSendData.id_trabajador">
          <optgroup label="trabajadores">
            <option selected></option>
            <option data-ng-repeat="trabajador in trabCampo" value="<% trabajador.id %>"><% trabajador.nombre+" "+trabajador.apellidos %></option>
          </optgroup>
        </select>
      </div>
      <div class="form-group col-sm-4 col-md-4 col-lg-4">
        <label for="actividad">Actividad:</label>
        <select form="clean" name="actividad" id="actividadSelect" class="form-control" data-ng-model="prepSendData.id_actividad" data-ng-change="getLabores()">
          <optgroup label="Actividades">
            <option selected></option>
            <option data-ng-repeat="actividad in lasactividades" value="<% actividad.id %>"><% actividad.nombre %></option>
          </optgroup>
        </select>
      </div>
      <div class="form-group col-sm-4 col-md-4 col-lg-4">
        <label for="labor" >Labor:</label>
        <select form="clean" name="labor" id="laborSelect" class="form-control" data-ng-model="prepSendData.id_labor" data-ng-change="selectLab()">
          <optgroup label="Labores" data-ng-controller="preplanilla">
            <option selected></option>
            <option data-ng-repeat="labor in laslabores" value="<% labor.id %>"><% labor.nombre %></option>
          </optgroup>
        </select>
      </div>
      <!--<div class="form-group col-sm-1 col-md-1 col-lg-1">
        <label for="tipoLabor">Tipo Prod</label>
        <input type="checkbox" class="form-control" data-ng-model="labValue">
      </div>-->
      <div class="form-group col-sm-4 col-md-4 col-lg-4" data-ng-show="labValue == 0">
        <label for="">horas trabajadas: </label>
        <input form="clean" type="text" class="form-control" data-ng-model="prepSendData.hora_trab" value="prepReg.aguinaldo">
      </div>
      <div class="form-group col-sm-4 col-md-4 col-lg-4" data-ng-show="labValue == 0">
        <label for="">horas extra: </label>
        <input form="clean" type="text" class="form-control" data-ng-model="prepSendData.hora_ext" value=0  >
      </div>
      <div class="form-group col-sm-4 col-md-4 col-lg-4" data-ng-show="labValue == 2">
        <label for="" class="control-label">Tamaño de cuje: </label>
        <select form="clean" class="form-control" data-ng-model="prepSendData.tamano_cuje">
          <option value="">Seleccionar</option>
          <option value="0">Pequeño</option>
          <option value="1">Grande</option>
        </select>
      </div>
      <div class="form-group col-sm-4 col-md-4 col-lg-4" data-ng-show="labValue == 2">
        <label for="" class="label-control">Cant. Cujes:</label>
        <input form="clean" type="text" class="form-control" data-ng-model="prepSendData.cant_cujes">
      </div>
      <div class="form-group col-sm-4 col-md-4 col-lg-4" data-ng-show="labValue == 2">
        <label for="">Cujes Extras: </label>
        <input form="clean" type="text" class="form-control" data-ng-model="prepSendData.cuje_ext">
      </div>
      <div class="form-group col-sm-4 col-md-4 col-lg-4" data-ng-show="labValue == 1">
        <label for="" class="control-label">Tamaño de Safadura: </label>
        <select form="clean" class="form-control" data-ng-model="prepSendData.tamano_safa">
          <option value="">Seleccionar</option>
          <option value="0">Pequeño</option>
          <option value="1">Grande</option>
        </select>
      </div>
      <div class="form-group col-sm-4 col-md-4 col-lg-4" data-ng-show="labValue == 1">
        <label for="" class="label-control">Cant. Safa:</label>
        <input form="clean" type="text" class="form-control" data-ng-model="prepSendData.cant_safa">
      </div>
      <div class="form-group col-sm-4 col-md-4 col-lg-4" data-ng-show="labValue == 1">
        <label for="">Safadura Extras: </label>
        <input form="clean" type="text" class="form-control" data-ng-model="prepSendData.safa_ext">
      </div>
      <div class="form-group col-sm-4 col-md-4 col-lg-4">
        <label for="">Otros: </label>
        <input form="clean" type="text" class="form-control clean" data-ng-model="prepSendData.otros" value=0>
      </div>
      <div class="form-group col-sm-4 col-md-4 col-lg-4">
        <label for="">Préstamos: </label>
        <input form="clean" type="text" class="form-control" data-ng-model="prepSendData.prestamos" value=0>
      </div>
      <div class="form-group col-sm-1 col-md-1 col-lg-1">
        <label class="control-label">Subsidio: </label>
        <input id="chkSub" type="checkbox" class="form-control"><!-- data-ng-model="prepSendData.subsidio"-->
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
@endsection
