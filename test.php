<?php
require_once "./Models.php";
class test extends Model
{
    public $id;
    public $nombre;
    public $apellido;
    public $edad;

    public function bcrypt()
    {
        return [
            "nombre",
            "apellido",
        ];
    }

    public function validate()
    {
        return [
            "nombre"=>"required|max:12",
            "apellido" => "max:5",
        ];
    }
}

?>