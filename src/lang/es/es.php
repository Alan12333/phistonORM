<?php


class es{

    private function Messages($index)
    {
        $array =  [
            "No se encontraron valores", "Esta función es redundante", "Esta función debe ir primero",
            "El atributo no puede estar vació", "Los Parámetros no pueden ser nulos",
            "Campo vació","limite de caracteres permitido excedido", "ingresa mas caracteres"
        ];
        return $array[$index];
    }

    public function Return($index)
    {
        return $this->Messages($index);
    }
}


?>