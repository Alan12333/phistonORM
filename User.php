<?php
class usuario extends Model
{

    public function bcrypt()
    {
        return [
            
        ];
    }

    public function validate()
    {
        return [
            "Nombre"=>"required",
            "Telefono" => "required,Int,max:10",
            "Correo"=>"required",
        ];
    }
}



?>