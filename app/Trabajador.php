<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trabajador extends Model
{
       protected $table = 'trabajadores';
       protected $fillable = ['nombre','nss','cedula','celular'];
}
