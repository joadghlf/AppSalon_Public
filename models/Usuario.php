<?php

namespace Model;

class Usuario extends ActiveRecord{

    public $id, $nombre, $apellido,$password, $password2, $email,$confirmado,$token,$admin,$telefono;
    protected static $columnasDB = ['id', 'nombre', 'apellido','password','email','confirmado','token','admin','telefono'];
    protected static $columnasTypeForm = ['id'=>'hidden','nombre'=>'text','password'=>'password','email'=>'email','telefono'=>'telephone','admin'=>['select','0','1'],'confirmado'=>['select','0','1']];
    protected static $tabla = 'usuarios';

    public function corroborarPass($password,$password2){
        if($password != $password2){
            self::$errores[] = "El password tiene que ser el mismo en los dos campos";
            }
    }

    private function chequearEmail(){
        $existe = false;
        $usuarioChek = self::find('email',$this->email);
        if(isset($usuarioChek->email)){
            if($usuarioChek->email === $this->email){
                $existe = true;
            }
        }
        return $existe;
    }

    public function existeEmail(){
        if($this->chequearEmail()){
            self::$errores[] = "El mail ya está registrado";
        }
    }

    public function chequarUsuario(){
        if($this->chequearEmail()){
            $usuarioChek = self::find('email',$this->email);
            if($usuarioChek->confirmado === "1"){                
                $this->comprobarPassword($usuarioChek);
            }else{
            self::$errores[] = "El mail aún no ha sido confirmado.</br>Busque en su casilla de correo el mail de confirmación.";
            }
        }else{
            self::$errores[] = "El mail no está registrado";
        }
    }

    protected function condicionalValidarDatos($key,$value){
        if ($key === 'password' && strlen($value) < 8) {
            self::$errores[] = "El password tiene que tener al menos 8 caracteres";
            }
        if ($key === 'password'){
            $lowcase = preg_match('/[a-z]/', $value);
            $uppcase = preg_match('/[A-Z]/', $value);
            $numbers = preg_match('/\d/', $value);
            $special = preg_match('/[^a-zA-Z\d]/', $value);
            if($lowcase === 0){
                self::$errores[] = "El password debe tener al menos una letra minúscula";
            }
            if($uppcase === 0){
                self::$errores[] = "El password debe tener al menos una letra mayúscula";
            }
            if($numbers === 0){
                self::$errores[] = "El password debe tener al menos un número";
            }
            if($special === 0){
                self::$errores[] = "El password debe tener al menos un caracter especial, como !%&(";
            }
        }
    } 

    public function hashPass(){
            $this->password = password_hash($this->password, PASSWORD_BCRYPT);
            $this->crearToken();
    }

    public function crearToken(){
        $this->token = base64_encode(uniqid()).uniqid().uniqid(); 
    }

    protected function comprobarPassword($request){
        $validacion = false;
        if(password_verify($this->password,$request->password)){//validamos el password
           comprobarSession();
            $_SESSION['usuario'] = $request;
            $_SESSION['loguin'] = true;
            $validacion = true;
        }else{
            self::$errores[] = 'El password es incorrecto';
        } 
        return $validacion;
    }

    protected function preCondicionalValidarDatos($key){
        if($key ==='admin' || $key ==='confirmado'){
            return true;
        }
        return false;
    }
}