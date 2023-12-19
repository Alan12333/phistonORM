<?php
require_once (__DIR__)."/filters.php";

class DataClean
{
    private $filter;

    function __construct()
    {
        $this->filter = new InputFilter();
    }

    public function CleanString($string)
    {
        $filterstring = "";

        if($string != "")
        {
            $filterstring = $this->filter->Process($string);
        }
        return $filterstring;
    }

    public function Clean($atribute)
    {
        $db = DB::Instance();
        $clean_string = mysqli_real_escape_string($db->Connection(), $atribute);
        return $this->CleanString($clean_string);
    }
}