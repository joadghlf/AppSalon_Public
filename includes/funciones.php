<?php

define('TEMPLATES_URL', __DIR__ .'/templates');
define('FUNCIONES_URL', __DIR__ . 'funciones.php');
define('CARPETA_IMAGENES', $_SERVER['DOCUMENT_ROOT'] . '/imagenes/');

function incluirTemplate(string $nombre , bool $inicio= false){
    include TEMPLATES_URL . "/${nombre}.php";
}

function crearCarpetaImagenes(){
     //**Subir archivos */
     echo CARPETA_IMAGENES;
     if(!is_dir(CARPETA_IMAGENES)){
         echo "no existe la carpeta";
         mkdir(CARPETA_IMAGENES);
     }else{
         echo "existe la carpeta";
     }
}

function debuguear($valor){
    echo '<pre>';
    var_dump($valor);
    echo '</pre>';
    exit;
}

function sanitizar($html){
    $sanitizado = null;
    if(isset($html)){
        $sanitizado = htmlspecialchars($html);
    }    
    return $sanitizado;
}

function validarTipoContenido($tipo = NULL){
    $tipos = ['vendedor','propiedad'];

    return in_array($tipo,$tipos);
}

    function mostrarMensaje($mensaje, $objeto = 'registro', $class = null){
        $msj ='';
    switch ($mensaje) {
        case 1:
            $msj = 'creado';
            break;
        case 2:
            $msj = 'actualizado';
        break;
        case 3:
            $msj = 'eliminado';
        break;
        case 4:
            $msj = 'enviado';
        break;
        default:
            $msj = FALSE;
        break;
    }
    if($msj){ ?>
        <p class="alerta exito">El <?php echo $objeto ?> ha sido <?php echo $msj ?> exitosamente</p>
    <?php }else{
        echo "<p class='alerta mensaje ${class}'>${mensaje}</p>";
        }
    }


    function validarIdURL($id){
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if(!$id){
            header("Location: /error");
        }
            return $id;
    }

    function comprobarSession(){
        $status = session_status();
        if($status == PHP_SESSION_NONE){
            //There is no active session
            session_start();
        }else
        if($status == PHP_SESSION_DISABLED){
            //Sessions are not available
        }else
        if($status == PHP_SESSION_ACTIVE){
            //Destroy current and start new one
            session_destroy();
            session_start();
        } 
    }

    function redirect($url,$mensaje = null){
        if(isset($mensaje)){
            header("Location: ${url}?mensaje=${mensaje}");
        }else{
            header("Location: ${url}");
        }

        exit;
    }

    function volver(){
        $url = $_SERVER['HTTP_REFERER'];
        header("Location: ${url}");
    }
    
    function imprimirVolver(){
        $url = $_SERVER['HTTP_REFERER'];
        echo $url;
    }

    function imprimirErrores($errores){
        if($errores !== ''){        
            foreach ($errores as $error) {
            ?> <div class="alerta error"> <?php
                                            echo $error;
                                            ?></div><?php
                    }
        }
    }

    function validarResultado($resultado){
        intval($resultado) ? mostrarMensaje(intval($resultado), "usuario") : false ;
    }

    //función que revisa que el usuario esté autenticado
    function isAuth(){
        if(isset($_SESSION['loguin'])){
            if($_SESSION['usuario']->admin === '1'){
                redirect('/admin/citas');
            }else{
                redirect('/citas');
            }            
        }
    }