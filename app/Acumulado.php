<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Acumulado extends Model
{
  protected $table="acumulados";
  protected $fillable['id_trabajador','vacaciones','aguinaldo','dias_vacs'];
}
