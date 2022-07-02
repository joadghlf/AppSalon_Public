<?php

namespace Model;

use Model\ActiveRecord;

class Cita extends ActiveRecord{

    public $id, $fecha, $hora, $idusuario;
    protected static $columnasDB = ['id', 'fecha', 'hora','idusuario'];
    protected static $columnasTypeForm = ['id'=>'hidden','fecha'=>'date','hora'=>'time'];
    protected static $tabla = 'citas';

}