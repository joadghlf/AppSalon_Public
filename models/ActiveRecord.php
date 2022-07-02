<?php

namespace Model;

class ActiveRecord{

  //Base de datos
  protected static $db;
  protected static $columnasDB = [];
  protected static $columnasTypeForm = [];
  protected static $errores = [];
  protected static $tabla = '';

   //Definir la conexión a la BD
   public static function setDB($database){
      self::$db = $database;
  }

  public function __construct($args = [])
  {
      foreach (static::$columnasDB as $campo) {
          if(isset($args["${campo}"])){
         $this->$campo = $args["${campo}"] ?? null;
        }
      }
  }

  public function datos(){
      $datos = [];
      foreach (static::$columnasDB as $columna) {
          if($columna ==='id') continue;
          $datos[$columna] = $this->$columna;
      }
      return $datos;
  }

  public function sanitizarDatos(){
      $datos = $this->datos();
      $sanitizado = [];
      foreach ($datos as $key => $value) {
         $sanitizado[$key] = self::escaparString($value);
      }
      return $sanitizado;
  }

  public function validarDatos(){
      $datos = $this->sanitizarDatos();
      foreach ($datos as $key => $value) {
            if($this->preCondicionalValidarDatos($key)) continue;
            if($key === "imagen") continue;
            if (!$value && $value != 0) {
              self::$errores[] = "Falta completar el campo " . $key;
            }else{
                $this->condicionalValidarDatos($key,$value);                       
            }
      }
      return self::$errores;
  }

  //función incluida en validarDatos que es pre condición dentro del for.
  protected function preCondicionalValidarDatos($key){
    return false;
  }


  //Si tiene fecha de inicio colocar
  public function fechaInicial($campo){
        $this->$campo = date('Y/m/d');
      } 

  //Acciones DB CRUD
  //Create

  public function create(){
      //Sanitización
      $datos = $this->sanitizarDatos();
      //crear un sctring a partir del un arreglo de datos
      $keysInsertar = join(', ',array_keys($datos));
      $valoresInsertar = join("', '",array_values($datos));

      $valoresInsertar = str_replace("''", 'null',$valoresInsertar);

      //insertar información en la base de datos
      $query = "INSERT INTO ".static::$tabla." ( ";
      $query .= $keysInsertar;
      $query .= " ) VALUES ( '";
      $query .= $valoresInsertar." ') ";
      
      //Para debugear: return json_encode((['query' => $query]));
      $resultado = self::$db->query($query);

      return [
                'resultado' => $resultado,
                'id' => self::$db->insert_id
      ];
  }

  //Read

  public static function all($limit = ''){  
      if($limit != ''){
          $limit = " LIMIT ".$limit;
      }  
      $query = "SELECT * FROM ".static::$tabla.$limit;
      $resultado = self::consultarSQL($query);
      return $resultado;
     
  }

  public static function find($parametros,$valores){
      $condiciones = '';
      if(is_array($parametros)){
      for ($i=0; $i < sizeof($parametros) ; $i++) { 
          $condiciones .= " {$parametros[$i]} = {$valores[$i]} and"; 
      }
      $condiciones = substr($condiciones, 0 , -3);
        }else{
            $condiciones = " lower({$parametros}) = lower('{$valores}') ";
        }
      $query = "SELECT * FROM ".static::$tabla." WHERE ";
      $query .= $condiciones . " ;";

      $resultado = self::consultarSQL($query);
      $resultado = array_shift($resultado);
      return $resultado;
  }

  public static function SQL($query){
    $resultado = self::consultarSQL($query);
    $resultado = $resultado;
    return $resultado;   
}

  public static function consultarSQL($query){
      //Consultar base de datos.
      $consulta = self::$db->query($query);
      $array = [];
      //Iterar resultados
      
      while ($registro = $consulta->fetch_assoc()) {
          $array[] = static::crearObjeto($registro);
      }
      //liberar la memoria
      $consulta->free();
      //retornar resultado
      return $array;
  }

  protected static function crearObjeto($registro){
      $objeto = new static;
      foreach ($registro as $key => $value) {
          if(property_exists($objeto, $key)){
              $objeto->$key = $value;
          }
      }
      return $objeto;
  }

  //Update

  //Sincronizar valores
  public function sincronizar($args = []){
      foreach ($args as $key => $value) {
          if(property_exists($this, $key)){
              $this->$key = $value;
          }            
      }
  }

  public function update(){
      //sanitizamos los datos
      $datos = $this->sanitizarDatos();
      //Armado de la query
      $query = "UPDATE ".static::$tabla. " SET ";
        $valoresInsertar = "";
      foreach ($datos as $key => $value) {
          $valoresInsertar .= $key." = '".$value."' ,";
      }
      $valoresInsertar = str_replace("''", 'null',$valoresInsertar);

      $query .= $valoresInsertar;
      //borramos el caracter adicional
      $query = substr($query, 0 , -1);
      $query .= " WHERE id=".$this->id;
      $query .= " LIMIT 1;";
      
      //EJecutamos la query
      $resultado = self::$db->query($query);
      //devolvemos el resultado
      return $resultado;    
  }

  //Delete

  public function delete(){
     if(property_exists($this,'imagen')){
        $this->deleteImage();
        }
      $query = "DELETE FROM ".static::$tabla. " WHERE id = '".self::escaparString($this->id)."' LIMIT 1 ;";
      $resultado = self::$db->query($query);
      return $resultado;
  }

  protected function deleteImage(){
      unlink(CARPETA_IMAGENES . $this->imagen);
  }
  

  //Get y Seteres
  public static function getErrores(){
      return self::$errores;
  }
  public function setImagen($nombreImagen){
      $this->imagen = $nombreImagen;
  }

  protected static function escaparString($string){
        $stringBack = null;
      if(isset($string)){
        $stringBack = self::$db->escape_string($string);
      }
        return $stringBack;
  }
  //Funciones condicionales

  protected function condicionalValidarDatos($key,$value){
  }

  protected function condicionalCreate($array = []){
  }

  public function formVal($campoClass,$camposNo = [],$action = '#', $submit = ["value"=>"Enviar","class"=>"btn btn-primary"], $classForm = 'formulario', $method = "POST"){
    $valores = $this->sanitizarDatos();
    $form ="";
    $form .= "<form action='${action}' class='${classForm}' method='${method}'>";
    $form .= "<input type='hidden' value='".substr(static::$tabla, 0, -1)."' name='type'>";
    foreach (static::$columnasTypeForm as $key => $value) {
        if(in_array($key,$camposNo))continue;
        if($this->condicional($key)){
            $form .= $this->condicionalForm($campoClass, $key, $valores);
        }else{                
            $valor = $valores[$key] ?? null;
            if($key === 'id'){
                $valor = $this->id;
            }
            if(is_array($value)){
                $condition = explode(" ", $value[0])[1] ?? null;
                if(explode(" ", $value[0])[0] ==="select"){
                    $form .= "<div class='${campoClass} ${key}'>";
                    $form .= "<label for='$key'>".ucfirst($key).": </label>";
                    $form .= "<select class ='${condition}' id='${key}'  name='${key}' value='${valor}' ".$condition.">";
                    for($i=1;$i<sizeof($value);$i++){
                        $selected = $valor ===$value[$i] ? 'selected' : '';
                        $form .= "<option ${selected} ".$value[$i]."'>".$value[$i]."</option>";
                    }
                    $form .= "</select>";
                    $form .= "</div>";
                    continue;
                }
            }
            if($value!='hidden'){
                $form .= "<div class='${campoClass} ${key}'>";
                $form .= "<label for='$key'>".ucfirst($key).": </label>";
            }
            $condition = explode(" ", $value)[1] ?? null;
            $form .= "<input class ='${condition}' type='".explode(" ", $value)[0]."' id='${key}'  name='${key}' value='${valor}' ".$condition.">";
            if($value!='hidden'){
                 $form .= "</div>";
            }
        }
    }
    $form .= "<input type='submit' class='".$submit['class']."' value=".$submit['value'].">";
    return $form;
  }

  protected function condicional($key){
    return false;
  }

  protected function condicionalForm($campoClass, $key, $valores){
        $form = '';
        return $form;
    }

    public function validarExistencia($datosValidar){
        if(!is_array($datosValidar)){
            
        }
        foreach ($datosValidar as $datoValidar => $value) {
            if(self::find($datoValidar,$value)){
                self::$errores[] = "Ya existe un/a ".static::$tabla." ". $value; 
                return true;
            }            
        }
        return false;
    }
}
   

/*
class inputForm{
    protected static $campoClass, $action, $classForm, $method, $submit; 
}*/