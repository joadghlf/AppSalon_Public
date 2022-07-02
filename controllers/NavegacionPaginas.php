<?php

namespace Controller;
use Model\Usuario;
use MVC\Router;

class NavegacionPaginas {

    public static function citas(Router $router){

        $mensaje = 'Hola, reserva tu turno en las fechas disponibles!';
        $usuario = $_SESSION['usuario'];
        
        $router->render('paginas/citas',[
            'mensaje' => $mensaje,
            'usuario' => $usuario
        ]);

    }

}