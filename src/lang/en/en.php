<?php


class en{

    private function Messages($index)
    {
        $array =  [
            "Not values found", "This function is redundant", "This function should be in the start",
            "This function must be executed at startup", "This function must be executed at startup",
            "This function must be executed at startup", "attribute must not be null", "Parameters must not be null",
            "input empty","the chars is "
        ];
        return $array[$index];
    }

    public function Return($index)
    {
        return $this->Messages($index);
    }
}


?>