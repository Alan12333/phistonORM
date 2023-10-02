<?php
/** @class: languages to phiston  (PHP8)
* @project: Phiston
* @date: 06-07-2023
* @version: 1.0_php8
* @author: Alan Guzman
* @copyright: Banira Digital
* @email: alan.guzman@baniradigital.com
* @license: GNU General Public License (GPL)
*/



class Lang{

    protected $language;

    protected $messages;

    function __construct($lang = "en")
    {
        $this->language = $lang;
        $this->messages = new Selector($lang);
    }

    public function ReturnMessage($index)
    {
        return $this->GetMessage($index);
    }

    private function GetMessage($index)
    {
        switch($this->language)
        {
            case "en":
                $message = new en;
                return $message->Return($index);
                break;
            case "es":
                $message = new es;
                return $message->Return($index);
                break;
        }
    }
}