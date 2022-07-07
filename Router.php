<?php


namespace MVC;

class Router{

    public $rutasGET = [];
    public $rutasPOST = [];

    public function get($url, $fin){        
        $this->rutasGET[$url] = $fin;
    }

    public function post($url, $fin){
        $this->rutasPOST[$url] = $fin;
    }

    public function comprobarRutas(){
        $rutas_protegidas_logueo = ['/citas','/logout'];
        $rutas_protegidas_admin = ['/admin/citas','/admin/servicios','/admin/usuarios','/admin/citas/modificar','/admin/usuarios/modificar','/admin/servicios/modificar','/admin/servicios/crear','/admin/usuarios/crear'];

        $urlActual = $_SERVER['REQUEST_URI'] === '' ? '/' : $_SERVER['REQUEST_URI'];
        $metodo = $_SERVER['REQUEST_METHOD'];

        echo '<pre>';
        var_dump($urlActual);
        echo '</pre>';

        
        comprobarSession();
        if($metodo === 'GET'){
         $fn = $this->rutasGET[$urlActual] ?? null;  
        }else{if($metodo === 'POST'){
            $fn = $this->rutasPOST[$urlActual] ?? null;
            }            
        }

        //Comprobando rutas protegidas por logueo
        if(in_array($urlActual, $rutas_protegidas_logueo)){
            if(!isset($_SESSION['loguin'])){
                header('Location: /');
                exit;
            }else{
                
            }
        }

        //Comprobando rutas Admin
        if(in_array($urlActual, $rutas_protegidas_admin)){
            if($_SESSION['usuario']->admin != 1){
                header('Location: /');
                exit;
            }
        }

        


        if($fn){            
            call_user_func($fn, $this);
        }else{
            echo "Página no encontrada";
        }
    }

    //Muestra una vista
    public function render($view, $datos = []){
        foreach ($datos as $key => $value) {
            $$key = $value;
        }

        ob_start();    //Almacenamiento en memoria durante un momento  
        // entonces incluimos la vista en el layout
        include_once __DIR__ . "/views/$view.php";
        $contenido = ob_get_clean(); // Limpia el Buffer
        include_once __DIR__ . '/views/layout.php';

    }

}