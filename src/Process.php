<?php

class Process
{
    protected $result = "";
    protected $querys;
    protected $sends;
    protected $model;
    protected $builds;

    function __construct($class_name)
    {
        $this->model = new $class_name;
        $this->sends = new Sends("POST", $class_name, $this->model);
        $this->querys = new Querys($class_name);
        $this->builds = new Builds;
    }

    public function ProcessQuery($name="", $parameters=null, $table="")
    {
        if($name === "GET")
        {
            return $this->get();
        }
        else
        {
            return $this->DefineQueryType($name, $parameters, $table);
        }
    }

    public function get()
    {
        if($this->result === "")
        {
            $res = $this->querys->getdata($this->result, "");
            return $this->builds->ExecuteData($res);
        }
        else
        {
            $res =  $this->result;
            return $this->builds->ExecuteData($res);
        }
    }

    public function store()
    {
        return $this->sends->Verifymethod();
    }

    private function DefineQueryType($querytype="",$params=null, $table="")
    {
        switch($querytype){

            case 'SELECT':
                $this->result = $this->querys->getdata($this->result,$params);
                break;

            case "TABLE":
                $this->result = $this->querys->getdatatable($this->result,$params);
                break;

            case "WHERE":
                $this->result = $this->querys->where($this->result,$params);
                break;
            
            case "JOIN":
                $this->result = $this->querys->join($this->result,$table,$params);
                break;

            case "INNER":
                $this->result = $this->querys->inner_join($this->result,$table,$params);
                break;
            
            case "LEFT":
                $this->result = $this->querys->left_join($this->result,$table,$params);
                break;
            
            case "RIGHT":
                $this->result = $this->querys->right_join($this->result,$table,$params);
                break;
            
            case "DESC":
                $this->result = $this->querys->desc($this->result,$params);
                break;

            case "ASC":
                $this->result = $this->querys->asc($this->result,$params);
                break;
            
            case "FIND":
                $this->result = $this->querys->find($this->result, $params);
                return $this->get();
                break;

            case "LAST":
                $this->result = $this->querys->findlast($this->result, $params);
                return $this->get();
                break;
            
            case "FIRST":
                $this->result = $this->querys->findfirst($this->result, $params);
                return $this->get();
                break;
            case "OR":
                $this->result = $this->querys->or($this->result, $params);
                break;
            case "AND":
                $this->result = $this->querys->and($this->result, $params);
                break;
            case "OR_WHERE":
                $this->result = $this->querys->or_where_null($this->result,$params);
                break;
            case "GROUPBY":
                $this->result = $this->querys->groupby($this->result, $params);
                break;
            case "LIMIT":
                $this->result = $this->querys->limit($this->result, $params);
                break;
            case "SUM":
                $this->result = $this->querys->sum($this->result, $params);
                break;
            case "QUERY":
                return $this->builds->ExecuteQuery($params);
                break;
        }
    }
}
