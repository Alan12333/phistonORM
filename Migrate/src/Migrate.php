<?php

/**
 * **********************************************************************************
 * Clase de migraciones para phiston, las migraciones son compatibles con mysql
 * 
 * @Vaersion 2.1.1
 * @author Alan Guzman
 * licencia GNU
 * **********************************************************************************
 */

class Migration
{
    protected $querys;

    function __construct()
    {
        $this->querys = new Querys("");
    }

    public static function CreateTable($table_name="", $columns=[])
    {
        $migration = new self();
        $result = $migration->querys->create_tbl($table_name, $columns);
        return $result;
    }

    public static function StartDrop($sql)
    {
        $migration = new self();
        $result = $migration->querys->drop_tbl($sql);
        $builds = new Builds;
        return $builds->ExecuteQuery($result);
    }

    public static function Start($sql)
    {
        $builds = new Builds;
        return $builds->ExecuteQuery($sql);
    }

    public static function StartUpdate($sql)
    {
        $migration = new self;
        $result = $migration->querys->tbl_descr($sql);
        $builds = new Builds;
        $actual_data = $builds->ExecuteData($result);
        
    }

}
