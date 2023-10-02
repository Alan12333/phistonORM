<?php

class ProcessErrors
{
    public static function displayMessage($error, $code, $line)
    {
        if(is_string($error))
        {
            return self::CreateMessage($error, $code, $line);
        }
        else
        {
            $lang = new Lang("es");
            return $lang->ReturnMessage($error);
        }
    }

    private static function CreateMessage($error, $code, $line)
    {
        return $error . " code. ".$code.". on line ".$line;
    }
}