<?php

namespace Model;

use Model\ActiveRecord;

class CitasServicio extends ActiveRecord{

    public $id, $idcita, $idservicio;
    protected static $columnasDB = ['id', 'idcita', 'idservicio'];
    protected static $tabla = 'citasservicios';

}