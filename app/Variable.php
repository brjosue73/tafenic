<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Variable extends Model
{
  protected $fillable = ['sal_dario','alimentacion','vacaciones','inss_campo','inss_admin','cuje_peq','cuje_grand','hora_ext','septimo'
  ];
  protected $table = "variables";
}
