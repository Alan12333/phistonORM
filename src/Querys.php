<?php

class Querys
{
    protected $data=[
        'SELECT',
        'FROM',
        'WHERE',
        'AND',
        'OR',
        'JOIN',
        'INNER',
        'LEFT',
        'RIGHT',
        'BETWEEN',
        'ORDER BY',
        'DESC',
        'ASC',
        'VALUES',
        'LIMIT',
        'INSERT',
        'DROP',
        'CREATE',
        'TABLE',
        'NULL',
        '*',
        'COUNT',
        'SUM',
        'ON',
        'GROUP BY',
        'LIMIT',
        'IF',
        'NOT',
    ];

    protected $class;

    function __construct($class_name)
    {
        $this->class = $class_name;
    }


    public function getdata($result,$params)
    {
        if($result === "" && $params === "")
        {
            return $this->data[0]." ".$this->data[20]." ".$this->data[1]." ".$this->class." ". $this->ObtenerAlias().";";
        }
        else if($result === "" && $params !== "")
        {
            return  $this->data[0]." ".$params." ".$this->data[1]." ".$this->class." ". $this->ObtenerAlias().";";
        }
        else if($result != "" && $params !== "")
        {
            $arreglo = explode(" ", $result);
            if($arreglo[0] === $this->data[0])
            {
                return $arreglo[0]." ".$params." ".$arreglo[2]." ".$arreglo[3]." ;";
            } 
        }
        else
        {
            return ProcessErrors::displayMessage("This function is redundant", 231, __LINE__);
        }
    }

    public function getdatatable($result, $params)
    {
        if($params === "")
        {
            return ProcessErrors::displayMessage("This function should be in the start", 232, __LINE__);
        }
        else
        {
            return $this->data[0]." ".$this->data[20]." ".$this->data[1]." ".$params.";";
        }
    }

    public function where($result,$params)
    {
        if(isset($params[1])===true)
        {
            $array = explode(";", $result);
            
            if($array[0] === "")
            {
                $variable = $this->data[0]." ".$this->data[20]." ".$this->data[1]." ".$this->class." ". $this->ObtenerAlias()."";
                return $variable . " ".$this->data[2]." ".$params[0]." ".$params[1]." '".$params[2]."' ;";
            }
            return $array[0]." ".$this->data[2]." ".$params[0]." ".$params[1]." '".$params[2]."' ;";
        }
        else
        {
            $array = explode(";", $result);
            return $array[0]." ".$this->data[2]." ".$params[0].";";
        }
    }

    public function join($result,$table, $params)
    {
        if(isset($params[1])===true)
        {
            $array = explode(";", $result);
            return $array[0]." ".$this->data[5]." ".$table." ".$this->data[23]." ".$params[0]." ".$params[1]." ".$params[2]." ;";
        } 
        else
        {
            $array = explode(";", $result);
            return $array[0]." ".$this->data[5]." ".$table." ".$this->data[20]." ".$params[0].";";
        }
    }

    public function inner_join($result,$table, $params)
    {
        if(isset($params[1])===true)
        {
            $array = explode(";", $result);
            return $array[0]." ".$this->data[6]." ".$this->data[5]." ".$table." ".$this->data[23]." ".$params[0]." ".$params[1]." ".$params[2]." ;";
        } 
        else
        {
            $array = explode(";", $result);
            return $array[0]." ".$this->data[6]." ".$this->data[5]." ".$table." ".$this->data[20]." ".$params[0].";";
        }
    }

    public function left_join($result,$table, $params)
    {
        if(isset($params[1])===true)
        {
            $array = explode(";", $result);
            return $array[0]." ".$this->data[7]." ".$this->data[5]." ".$table." ".$this->data[23]." ".$params[0]." ".$params[1]." ".$params[2]." ;";
        } 
        else
        {
            $array = explode(";", $result);
            return $array[0]." ".$this->data[7]." ".$this->data[5]." ".$table." ".$this->data[20]." ".$params[0].";";
        }
    }

    public function right_join($result,$table, $params)
    {
        if(isset($params[1])===true)
        {
            $array = explode(";", $result);
            return $array[0]." ".$this->data[8]." ".$this->data[5]." ".$table." ".$this->data[23]." ".$params[0]." ".$params[1]." ".$params[2]." ;";
        } 
        else
        {
            $array = explode(";", $result);
            return $array[0]." ".$this->data[8]." ".$this->data[5]." ".$table." ".$this->data[20]." ".$params[0].";";
        }
    }

    public function desc($result, $params)
    {
        if($params === "")
        {
            $array = explode(";", $result);
            if($array[0] === "")
            {
                $variable = $this->data[0]." ".$this->data[20]." ".$this->data[1]." ".$this->class." ". $this->ObtenerAlias()."";
                return $variable ." ".$this->data[10]." id ".$this->data[11]." ;";
            }
            return $array[0]." ".$this->data[10]." id ".$this->data[11]." ;";
        }
        else
        {
            $array = explode(";", $result);
            if($array[0] === "")
            {
                $variable = $this->data[0]." ".$this->data[20]." ".$this->data[1]." ".$this->class." ". $this->ObtenerAlias()."";
                return $variable ." ".$this->data[10]." ".$params." ".$this->data[12]." ;";
            }
            return $array[0]." ".$this->data[10]." ".$params." ".$this->data[12]." ;";
        }
    }

    public function asc($result, $params)
    {
        if($params === "")
        {
            $array = explode(";", $result);
            return $array[0]." ".$this->data[10]." id ".$this->data[12]." ;";
        }
        else
        {
            $array = explode(";", $result);
            return $array[0]." ".$this->data[10]." ".$params." ".$this->data[12]." ;";
        }
    }

    public function and($result, $params)
    {
        if(isset($params[1])===true)
        {
            $array = explode(";", $result);
            return $array[0]." ".$this->data[3]." ".$params[0]." ".$params[1]." ".$params[2]." ;";
        } 
        else
        {
            $array = explode(";", $result);
            return $array[0]." ".$this->data[3]." ".$params[0].";";
        }
    }

    public function or($result, $params)
    {
        if(isset($params[1])===true)
        {
            $array = explode(";", $result);
            return $array[0]." ".$this->data[4]." ".$params[0]." ".$params[1]." ".$params[2]." ;";
        } 
        else
        {
            $array = explode(";", $result);
            return $array[0]." ".$this->data[4]." ".$params[0].";";
        }
    }

    public function findlast($result, $params)
    {   
        if($result === "" && $params === "")
        {
            return $this->data[0]." ".$this->data[20]." ".$this->data[1]." ".$this->class." ".$this->data[10]." id ".$this->data[11]." ".
            $this->data[14]." 1 ;";
        }
        else if($result==="" && $params !== "")
        {
            return $this->data[0]." ".$params." ".$this->data[1]." ".$this->class." ".$this->data[10]." id ".$this->data[11]." ".
            $this->data[14]." 1 ;";
        }
        else{
            ProcessErrors::displayMessage("This function must be executed at startup", 235, __LINE__);
        }
    }

    public function find($result, $params)
    {   
        if($result === "" )
        {
            return $this->data[0]." ".$this->data[20]." ".$this->data[1]." ".$this->class." ".$this->data[2]." id = ".$params.";";
        }
        else{
            ProcessErrors::displayMessage("This function must be executed at startup", 235, __LINE__);
        }
    }

    public function findfirst($result, $params)
    {   
        if($result === "" && $params === "")
        {
            $cmd = $this->data[0]." ".$this->data[20]." ".$this->data[1]." ".$this->class." ".$this->data[10]." id ".$this->data[12]." ".
            $this->data[14]." 1 ;";
            return $cmd;
        }
        else if($result==="" && $params !== "")
        {
            $cmd= $this->data[0]." ".$params." ".$this->data[1]." ".$this->class." ".$this->data[10]." id ".$this->data[12]." ".
            $this->data[14]." 1 ;";
            return $cmd;
        }
        else{
            ProcessErrors::displayMessage("This function must be executed at startup", 235, __LINE__);
        }
    }

    public function or_where_null($result, $params)
    {
        $array = explode(";", $result);
        if($params == "")
        {
            ProcessErrors::displayMessage("attribute must not be null",503,__LINE__);
        }
        else
        {
            return $array[0]." ".$this->data[4]." ".$params." IS NULL;";
        }
    }

    public function groupby($result, $params)
    {
        $array = explode(";", $result);
        if($params === "")
        {
            ProcessErrors::displayMessage("Parameters must not be null",503,__LINE__);
        }
        else
        {
            return $array[0]." ".$this->data[24]." ".$params.";";
        }
    }

    public function sum($result, $params)
    {
        $array = explode(" ", $result);
        if(count($array) <= 1)
        {
            $array = explode( " ", $this->getdata($result, ""));
        }

        if($params === "")
        {
            ProcessErrors::displayMessage("Parameters must not be null",503,__LINE__);
        }
        else
        {
            for($i =0; $i < count($array); $i++)
            {
                if($array[$i] === "SELECT")
                {
                    if($array[$i+1] == "FROM" || $array[$i + 1]==="*")
                    {
                        $array[$i] = $array[$i]." ".$this->data[22]."(".$params.") ";
                    }
                    else
                    {
                        $array[$i] = $array[$i]." ".$this->data[22]."(".$params."), ";
                    }
                }
                if($array[$i] === "*")
                {
                    $array[$i] = "";
                }
            }
            $newquery = join(" ",$array);
            return $newquery;
        }
    }

    public function limit($result, $params)
    {
        $array = explode(";", $result);
        if($params === "")
        {
            ProcessErrors::displayMessage("Parameters must not be null",503,__LINE__);
        }
        else
        {
            return $array[0]." ".$this->data[25]." ".$params.";";
        }
    }

    private function ObtenerAlias()
    {
        $array =[];
        $newalias = [];
        $array = str_split($this->class);
        $newalias[] = $array[0];
        $newalias[] = $array[1];
        $newalias[] = $array[2];
        $alias = implode("",$newalias);
        return $alias;
    }

    public function create_tbl($name, $atributes)
    {
        $sql = $this->data[17]." ".$this->data[18]." ".$this->data[26]." ".$this->data[27]." EXISTS {$name} (";
        foreach($atributes as $column => $atr)
        {
            $sql .="{$column} {$atr}, ";
        }
        $sql = trim($sql, ', ').');';

        return $sql;
    }

    public function drop_tbl($sql)
    {
        $explode = explode("CREATE TABLE IF NOT EXISTS", $sql);
        $explode2 = explode("(", $explode[1]);
        $table = $explode2[0];
        $cmd = $this->data[16]." ".$this->data[18]." ".$this->data[26]." EXISTS $table;";
        $cmd = $cmd." ".$sql;
        return $cmd;
    }

    public function update_tbl($sql)
    {
        $explode = explode("CREATE TABLE IF NOT EXISTS", $sql);
        $explode2 = explode("(", $explode[1]);
        $table = $explode2[0];
        
    }
}