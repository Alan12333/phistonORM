<?php


class es{

    private function Messages($index)
    {
        $array =  [
            "no es un correo valido",
            "no es de tipo entero",
            "no es de tipo flotante",
            "no es de tipo booleano",
            "es requerido",
            "es mayor que el requerido",
            "es menor que el requerido"
        ];
        return $array[$index];
    }

    public function Return($index)
    {
        return $this->Messages($index);
    }
}


?>