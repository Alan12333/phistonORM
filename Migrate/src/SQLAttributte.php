<?php
/**
 * **********************************************************************************
 * Clase de atributos para construir la consulta
 * 
 * @Vaersion 2.1.1
 * @author Alan Guzman
 * licencia GNU
 * **********************************************************************************
 */

class SQLAttributes
{

    public static function Id()
    {
        return "INT PRIMARY KEY AUTO_INCREMENT";
    }

    public static function varchar($length, $nullable = false)
    {
        return "VARCHAR({$length})" . ($nullable ? ' NULL' : ' NOT NULL');
    }

    public static function int($nullable = false)
    {
        return "INT" . ($nullable ? ' NULL' : ' NOT NULL');
    }

    public static function text($nullable = false)
    {
        return "TEXT" . ($nullable ? ' NULL' : ' NOT NULL');
    }

    public static function boolean($nullable = false)
    {
        return "BOOLEAN" . ($nullable ? ' NULL' : ' NOT NULL');
    }

    public static function date($nullable = false)
    {
        return "DATE" . ($nullable ? ' NULL' : ' NOT NULL');
    }

    public static function float($nullable = false)
    {
        return "FLOAT" . ($nullable ? ' NULL' : ' NOT NULL');
    }
    public static function decimal($nullable = false)
    {
        return "DECIMAL" . ($nullable ? ' NULL' : ' NOT NULL');
    }
    public static function double($nullable = false)
    {
        return "DOUBLE" . ($nullable ? ' NULL' : ' NOT NULL');
    }
    public static function real($nullable = false)
    {
        return "REAL" . ($nullable ? ' NULL' : ' NOT NULL');
    }
    public static function bit($nullable = false)
    {
        return "BIT" . ($nullable ? ' NULL' : ' NOT NULL');
    }
    public static function datetime($nullable = false)
    {
        return "DATETIME" . ($nullable ? ' NULL' : ' NOT NULL');
    }
    public static function time_stamp($nullable = false)
    {
        return "TIMESTAMP" . ($nullable ? ' NULL' : ' NOT NULL');
    }
    public static function time($nullable = false)
    {
        return "DATETIME" . ($nullable ? ' NULL' : ' NOT NULL');
    }
    public static function year($nullable = false)
    {
        return "DATETIME" . ($nullable ? ' NULL' : ' NOT NULL');
    }
    public static function createdAt()
    {
        return "TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL";
    }

    public static function updatedAt()
    {
        return "TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL";
    }
}

?>