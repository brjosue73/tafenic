<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class QuincenalesController extends Controller
{
    public function prueba(){
      $fecha=date("d-m-Y");
      $fecha2=date("d-m-Y");

      $fecha3='fecha1: '.$fecha.' fecha2: '.$fecha2;
      return $fecha3;

    }
}
