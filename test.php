<?php
require_once "./Models.php";
class test extends Model
{

    public function bcrypt()
    {
        return [
            "password",
        ];
    }

    public function validate()
    {
        return [
            "nombre"=>"required",
            "apellido" => "required",
            "edad"=>"required,Int",
            "password"=>"required"
        ];
    }
}

?>