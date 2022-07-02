<?php

namespace Model;

class Servicio extends ActiveRecord{
    public $id, $nombre, $precio;
    protected static $columnasDB = ['id', 'nombre', 'precio'];
    protected static $columnasTypeForm = ['id'=>'hidden','nombre'=>'text','precio'=>'number'];
    protected static $tabla = 'servicios';
}