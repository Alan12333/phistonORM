<?php
class Model
{
    /**
     * **********************************************************************************
     * Clase de modelos para phiston, los modelos son compatibles con mysql
     * 
     * @Vaersion 2.1.1
     * @author Alan Guzman
     * licencia GNU
     * **********************************************************************************
     */
    private static $result;
    private static $process;


    public static function table($tablename)
    {
        self::$process = new Process(Model::class);
        self::$result = self::$process->ProcessQuery("TABLE", $tablename);
        return new self;
    }

    public static function select($parameters="")
    {
        if (!isset(self::$process)) {
            self::$process = new Process(get_called_class());
        }
        self::$result = self::$process->ProcessQuery("SELECT", $parameters);
        return new self;
    }

    public static function where(...$params)
    {
        if (!isset(self::$process)) {
            self::$process = new Process(get_called_class());
        }
        self::$result = self::$process->ProcessQuery("WHERE", $params);
        return new self;
    }

    public static function inner_join($table, ...$params)
    {
        self::$result = self::$process->ProcessQuery("INNER", $params, $table);
        return new self;
    }

    public static function join($table, ...$params)
    {
        if (!isset(self::$process)) {
            self::$process = new Process(get_called_class());
        }
        self::$result = self::$process->ProcessQuery("JOIN", $params, $table);
        return new self;
    }

    public static function left_join($table, ...$params)
    {
        self::$result = self::$process->ProcessQuery("LEFT", $params, $table);
        return new self;
    }

    public static function right_join($table, ...$params)
    {
        self::$result = self::$process->ProcessQuery("RIGHT", $params, $table);
        return new self;
    }

    public static function desc($params="")
    {
        self::$result = self::$process->ProcessQuery("DESC", $params);
        return new self;
    }

    public static function asc($params="")
    {
        self::$result = self::$process->ProcessQuery("ASC", $params);
        return new self;
    }

    public static function find($params)
    {
        if (!isset(self::$process)) {
            self::$process = new Process(get_called_class());
        }
        self::$result = self::$process->ProcessQuery("FIND", $params);
        return self::$result;
    }

    public static function findlast($params="")
    {
        if (!isset(self::$process)) {
            self::$process = new Process(get_called_class());
        }
        self::$result = self::$process->ProcessQuery("LAST", $params);
        return self::$result;
    }

    public static function findfirst($params="")
    {
        if (!isset(self::$process)) {
            self::$process = new Process(get_called_class());
        }
        self::$result = self::$process->ProcessQuery("FIRST", $params);
        return self::$result;
    }

    public static function or(...$params)
    {
        self::$result = self::$process->ProcessQuery("OR", $params);
        return new self;
    }

    public static function and(...$params)
    {
        self::$result = self::$process->ProcessQuery("AND", $params);
        return new self;
    }

    public static function or_where_null($atruibute)
    {
        self::$result = self::$process->ProcessQuery("OR_WHERE", $atruibute);
        return new self;
    }

    public static function groupby($params)
    {
        self::$result = self::$process->ProcessQuery("GROUPBY", $params);
        return new self;
    }

    public static function get()
    {
        if (!isset(self::$process)) {
            self::$process = new Process(get_called_class());
        }
        self::$result = self::$process->ProcessQuery("GET");
        return self::$result;
    }

    public static function store(...$params)
    {
        self::$process = new Process(get_called_class());
        self::$result = self::$process->store("POST", $params);
        return self::$result;
    } 

    public static function sum($param)
    {
        if (!isset(self::$process)) {
            self::$process = new Process(get_called_class());
        }
        self::$result = self::$process->ProcessQuery("SUM", $param);
        return new self;
    }

    public static function limit($num)
    {
        self::$result = self::$process->ProcessQuery("LIMIT", $num);
        return new self;
    }

    public static function query($cmd)
    {
        self::$process = new Process(get_called_class());
        self::$result = self::$process->ProcessQuery("QUERY", $cmd);
        return self::$result;
    }
}

?>