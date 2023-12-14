<?php


class en{

    private function Messages($index)
    {
        $array =  [
            "not is type Mail",
            "not is type Int",
            "not is type Float",
            "not is type Boolean",
            "is required",
            "field value is greater than required.",
            "field value is less than required"
        ];
        return $array[$index];
    }

    public function Return($index)
    {
        return $this->Messages($index);
    }
}


?>