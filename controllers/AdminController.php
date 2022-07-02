<?php
namespace Controller;

use Model\AdminCita;
use Model\Cita;
use Model\Servicio;
use Model\Usuario;
use MVC\Router;
class AdminController{

    public static function index(Router $router){
        
        $fecha = $_GET['fecha'] ?? date('Y-m-d');
        $fechaArray = explode("-",$fecha);
        if(!checkdate($fechaArray[1],$fechaArray[2],$fechaArray[1])){
            $script = "<script>".
                        "document.addEventListener('DOMContentLoaded', function () {".
                            "let mensaje = ['La fecha ingresada es incorrecta'];".
                            "mostrarAlerta(mensaje,'error')".
                        "});".
                      "</script>";
            $router->render('admin/index',[
                'script' => $script
            ]);
        }

        $consulta = "SELECT citas.id, CONCAT(citas.fecha, ' ',citas.hora) as cita, CONCAT (usuarios.nombre,' ',usuarios.apellido) as cliente, usuarios.email, usuarios.telefono, servicios.nombre as servicio, servicios.precio FROM citas left outer JOIN usuarios ON citas.idusuario = usuarios.id LEFT OUTER JOIN citasservicios ON citasservicios.idcita = citas.id LEFT OUTER JOIN servicios ON servicios.id = citasservicios.idservicio WHERE citas.fecha = '".$fecha.";'";
        $citas = AdminCita::SQL($consulta);        
        $router->render('admin/citas',[
                'citas' => $citas,
                'fecha' => $fecha,
                'crear' => true
        ]);
    }  
    
    public static function servicios(Router $router){
        $servicios = Servicio::all();
        $router->render('admin/servicios',[
            'servicios' => $servicios,
            'crear' => true
        ]);
    }
    


    public static function crear(Router $router){
        $script = '';
        $errores = [];
        $type = $_GET['type'];
        $btnServicios = '';
        $btnUsuarios = '';
        $btnCitas = '';
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $post = $_POST;
        }else{
            $post = null;
        }
        switch ($type) {
                case 'servicio':
                $btnServicios = 'btn-select';
                $element = new Servicio($post);
                break;
            case 'cita':
               $element = new Cita($post);
                $btnCitas = 'btn-select';
                break;
            case 'usuario':
                $element = new Usuario($post);
                $btnUsuarios = 'btn-select';
                break;
            default:
                break;
        }

        if($_SERVER['REQUEST_METHOD']==='POST'){
            $element->validarExistencia(['nombre'=>$element->nombre]);
            $errores = $element->validarDatos();
            $script = "<script>";
            $script .= "document.addEventListener('DOMContentLoaded', function () {";
            if(empty($errores)){                
                $element->create();
                if($type ==='cita'){
                }
                $script .=  "let mensaje = ['Datos creados'];";
                $script .=  "let tipo = 'exito';";                           
            }
            $script .= "mostrarAlerta(mensaje, tipo)".
                        "});".
                      "</script>";
        }


        $router->render('admin/templates/crear',[
            'errores' => $errores,
            'type' => $type,
            'element' => $element,
            'btnCitas' => $btnCitas,
            'btnServicios' => $btnServicios,
            'btnUsuarios' => $btnUsuarios,
            'script' => $script
        ]);
    }

    public static function modificar(Router $router){
        $camposNo = [];
        $script = '';
        $errores = [];
        $type = $_GET['type'];
        if(is_numeric($_GET['id'])){
            $id = $_GET['id']; 
        }else{
            volver();
        }        
        $btnServicios = '';
        $btnUsuarios = '';
        $btnCitas = '';     
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id = $_POST['id'];
            $type = $_POST['type'];
            $elementSinc = $_POST;
        }
        switch ($type) {
            case 'servicio':
                $element = Servicio::find('id',$id);
                $btnServicios = 'btn-select';
                break;
            case 'cita':
                $consulta = "SELECT citas.id, CONCAT(citas.fecha, ' ',citas.hora) as cita, CONCAT (usuarios.nombre,' ',usuarios.apellido) as cliente, usuarios.email, usuarios.telefono, servicios.nombre as servicio, servicios.precio FROM citas left outer JOIN usuarios ON citas.idusuario = usuarios.id LEFT OUTER JOIN citasservicios ON citasservicios.idcita = citas.id LEFT OUTER JOIN servicios ON servicios.id = citasservicios.idservicio WHERE citas.id = '".$id.";'";
                if($_SERVER['REQUEST_METHOD'] === 'POST'){
                $element = Cita::find('id',$id);
                }else{
                $element = AdminCita::SQL($consulta);
                $element = $element[0];
                }                
                $btnCitas = 'btn-select';
                break;
            case 'usuario':
                    $element = Usuario::find('id',$id);
                    $btnUsuarios = 'btn-select';
                    $camposNo = ['password'];
                    break;
            default:
                # code...
                break;
        }
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $element->sincronizar($elementSinc);
            $errores = $element->validarDatos();            
            $script = "<script>";
            $script .= "document.addEventListener('DOMContentLoaded', function () {";
            if(empty($errores)){
                $element->update();
                if($type ==='cita'){
                    $element = AdminCita::SQL($consulta);
                    $element = $element[0];
                }
                $script .=  "let mensaje = ['Datos actualizados'];";
                $script .=  "let tipo = 'exito';";                           
            }
            $script .= "mostrarAlerta(mensaje, tipo)".
                        "});".
                      "</script>";
        }
        
        $router->render('admin/templates/modificar',[
            'errores' => $errores,
            'type' => $type,
            'element' => $element,
            'btnCitas' => $btnCitas,
            'btnServicios' => $btnServicios,
            'btnUsuarios' => $btnUsuarios,
            'script' => $script,
            'camposNo' => $camposNo
        ]);
    }

    public static function usuarios(Router $router){
        $usuarios = Usuario::all();
        $router->render('admin/usuarios',[
            'crear' => true,
            'usuarios' => $usuarios
        ]);


    }
    
}