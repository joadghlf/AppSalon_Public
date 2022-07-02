<?php

namespace Model;

class AdminCita extends ActiveRecord{
    protected static $tabla = 'citas';
    protected static $columnasDB = ['id', 'cita','cliente','email','telefono','servicio','precio'];
    protected static $columnasTypeForm = ['id'=>'hidden', 'cliente'=>'text disabled','email'=>'text disabled','telefono'=>'text disabled','cita'=>'text'];
    public $id, $cita, $cliente, $email, $telefono, $servicio, $precio;


    protected function condicional($key){
        if($key === 'cita'){
            return true;
        }
        return false;
    }

    protected function condicionalForm($campoClass, $key, $valores){
                $form = '';
                $valor = explode(" ", $valores[$key]) ?? null;
                $form .= "<div class='${campoClass} fecha'>";
                $form .= "<label for='fecha'>Fecha: </label>";
                $form .= "<input type='date' id='fecha' name='fecha' value='".$valor[0]."'>";
                $form .= "</div>";
                $form .= "<div class='${campoClass} hora'>";
                $form .= "<label for='hora'>Hora: </label>";
                $form .= "<input type='time' id='hora' name='hora' value='".$valor[1]."'>";
                $form .= "</div>";
                return $form;
    }

    public function actCita(){        
        $cita = Cita::find('id',$this->id);
        $cita->sincronizar($this->sanitizarDatos());
        debuguear($cita);
    }


    /*
    public function formVal($campoClass,$action = '#', $submit = ["value"=>"Enviar","class"=>"btn btn-primary"], $classForm = 'formulario', $method = "POST"){  
        $valores = $this->sanitizarDatos();
        $form ="";
        $form .= "<form action='${action}' class='${classForm}' method='${method}'>";
        $form .= "<input type='hidden' value='".substr(static::$tabla, 0, -1)."' name='type'>";
        foreach (static::$columnasTypeForm as $key => $value) {
            if($key === 'cita'){
                
            }else{
                $valor = $valores[$key] ?? null;
                $condition = explode(" ", $value)[1] ?? null;
                if($value!='hidden'){
                   $form .= "<div class='${campoClass} ${key} ${condition}'>";
                   $form .= "<label for='$key'>".ucfirst($key).": </label>";
                }                   
                   $form .= "<input type='".explode(" ", $value)[0]."' id='${key}' value='${valor}' ".$condition.">";
                if($value!='hidden'){
                   $form .= "</div>";
                }
            }           
        }
        $form .= "<input type='submit' class='".$submit['class']."' value=".$submit['value'].">";
        return $form;
      }*/
}