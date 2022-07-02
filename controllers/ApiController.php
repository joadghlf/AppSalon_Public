<?php

namespace Controller;

use Model\Cita;
use Model\Citas;
use Model\CitasServicio;
use Model\Servicio;

class ApiController{

    public static function index(){
        
        $servicios = Servicio::all();
        echo json_encode($servicios);

    }

    public static function reservar(){
        $cita = new Cita($_POST);
        $respuesta = $cita->create();
        $servicios = $_POST['servicios'];
        
        $servicios = explode(",", $servicios);
        $citaServicio =  new CitasServicio();
        foreach ($servicios as $servicio) {
            $citaServicio->sincronizar(['idcita'=>$respuesta['id'],'idservicio'=>$servicio]);
            $citaServicio->create();
        }

        echo json_encode($respuesta);
    }

    public static function eliminar(){
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $cita = Cita::find('id',(int)$_POST['idcita']);
            $cita->delete();
            header('Location: '.$_SERVER['HTTP_REFERER']);
            exit;
        }
    }

    

}