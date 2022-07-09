<?php

namespace Controller;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoguinController
{

    public static function loguin(Router $router)
    {
        //isAuth();
        $resultado = $_GET['resultado'] ?? null;
        $usuario = new Usuario();
        $errores = [];


        if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $usuario->sincronizar($_POST);
        $usuario->chequarUsuario();
        $errores = $usuario->getErrores();
        if(empty($errores)){
            if($_SESSION['usuario']->admin === '1'){
                redirect('/');
            }
        }else{
            $router->render('auth/loguin',[
                'errores' => $errores,
                'resultado' => $resultado,
                'usuario' => $usuario
            ]);
        }   
        redirect('/');
        }   
        
        $router->render('auth/loguin', [
            'errores' => $errores,
            'resultado' => $resultado,
            'usuario' => $usuario
        ]);
    }

    public static function logout()
    {
        comprobarSession();
        session_destroy();
        redirect('/','sesión cerrada correctamente');
    }

    public static function olvide(Router $router)
    {
        $errores = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = Usuario::find('email',$_POST['email']);
            if(isset($usuario)){
                if(isset($usuario->confirmado)){
                    $mensaje = 'se ha enviado un mail a su casilla de correo para renovar la contraseña';
                    $usuario->crearToken();
                    $usuario->update();
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->recuperarPassword();
                    redirect('/',$mensaje);
                }else{
                    $errores[] = 'El mail aún no ha sido confirmado, debe confirmar el mail para luego ejecutar el proceso de recuperar password'; 
                }                
            }else{
                $errores[] = 'El mail ingresado no es correcto';                
            }
        }
        $router->render('auth/olvide',[
            'errores' => $errores
        ]);
    }

    public static function recuperarPassword(Router $router)
    {
        $errores = [];
        $token = $_GET['token'] ?? null;
       
        if (isset($token)) {
            $usuario = Usuario::find('token', $token);
            if (isset($usuario)) {
                if($_SERVER['REQUEST_METHOD'] === 'POST'){
                    $usuario->password = $_POST['password'];
                    $usuario->password2 = $_POST['password2'];
                    $usuario->corroborarPass($_POST['password'], $_POST['password2']);
                    $errores = $usuario->validarDatos();
                    $usuario->hashPass();
                    if(empty($errores)){
                        $usuario->token = null;
                        $usuario->update();
                        redirect('/','Password actualizado, ya puede loguearse');
                    }else{
                        $router->render('auth/recuperarpassword',[
                            'errores' => $errores,
                            'token' => $token
                        ]);
                    }
                    
                }                
                $router->render('auth/recuperarpassword',[
                            'errores' => $errores,
                            'token' => $token 
                        ]);
            }
                else {
                    redirect('/', 'No se ha podido validar la cuenta');
            }
        }else {
                redirect('/', 'No se ha podido validar la cuenta');
        }
    }


    public static function crear(Router $router)
    {
        $usuario = new Usuario();
        $errores = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            $usuario->corroborarPass($_POST['password'], $_POST['password2']);
            $usuario->existeEmail();
            $errores = $usuario->validarDatos();
            $usuario->hashPass();
            $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
            $email->enviarConfirmacion();

            if (empty($errores)) {
                $resultado = $usuario->create();
                if ($resultado) {
                    redirect('/','Se envió un mail a su casilla de correo, allí podrá validar su cuenta');
                }
            } else {
                $router->render('auth/crear', [
                    'errores' => $errores,
                    'usuario' => $usuario
                ]);
                exit;
            }
        }


        $router->render('auth/crear', [
            'errores' => $errores,
            'usuario' => $usuario
        ]);
    }

    public static function confirmarCuenta()
    {
        $errores = [];
        $token = $_GET['token'] ?? null;
        if (isset($token)) {
            $usuario = Usuario::find('token', $token);
            if (isset($usuario)) {
                if (!isset($usuario->confirmado)) {
                    $usuario->confirmado = 1;
                    $usuario->token = null;
                    $resultado = $usuario->update();
                    if ($resultado) {
                        redirect('/', 'Usuario confirmado, ya puede loguearse');
                    } else {
                        redirect('/', 'Surgió un error al tratar de validar el usuario');
                    }
                } else {
                    redirect('/', 'El usuario ya estaba confirmado');
                }
            } else {
                redirect('/', 'No se ha podido validar la cuenta');
            }
        } else {
            redirect('/', 'No se ha podido validar la cuenta');
        }
    }

    public static function solicitarTurno(){
        echo "desde solicitar turno";
    }
}
