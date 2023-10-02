<?php
class Selector
{
    public function __construct($lang)
    {
        switch($lang){
            case "en":
                require_once (__DIR__)."/en/en.php";
                break;
            case "es":
                require_once (__DIR__)."/es/es.php";
                break;
        }
    }
}

?>