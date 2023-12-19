<?php

class Sends
{
    protected $builds;

    protected $token;

    protected $result;

    protected $values;

    protected $attributes;

    protected $model_name;

    protected $model;

    protected $clean;


    function __construct($model_name, $model)
    {
        $this->clean = new DataClean;
        $this->model = $model;
        $this->model_name = $model_name;
        $this->builds = new Builds;
    }

    public function Verifymethod($method, $param="", $values="")
    {
        if($method === "POST")
        {
            if($_SERVER['REQUEST_METHOD'] ==='POST')
            {
                $exec = $this->GetAttributes($method);
                if($exec === true)
                {
                    return $this->builds->CreateData($this->model_name, $this->attributes, $this->values, $param);
                }
                else
                {
                    return $exec;
                }
            }
            else
            {
                return http_response_code(405);
            }
        }
        else if($method === "PUT")
        {
            if($_SERVER['REQUEST_METHOD'] ==='PUT' || $_SERVER['REQUEST_METHOD'] ==='POST')
            {
                $exec = $this->GetAttributes($method);
                if($exec === true)
                {
                    return $this->builds->UpdateData($this->model_name, $this->attributes, $this->values, $param, $values);
                }
                else
                {
                    return $exec;
                }
            }
            else
            {
                return http_response_code(405);
            }
        }
        else if($method === "DELETE")
        {
            if($_SERVER['REQUEST_METHOD'] ==='POST')
            {
                $exec = $this->GetAttributes("PUT");
                if($exec === true)
                {
                    return $this->builds->DeleteData($this->model_name, $param, $values);
                }
                else
                {
                    return $exec;
                }
            }
            else
            {
                return http_response_code(405);
            }
        }
    }

    // private function VerifyToken()
    // {
    //     if(isset($_POST['token']))
    //     {
    //         // if($_POST['token']=== Ses::token())
    //         // {
    //         //     return true;
    //         // }
    //         // else
    //         // {
    //             $token = $_POST['token'];
    //             $cmd = "SELECT * FROM token WHERE _token='$token'";
    //             $result = $this->execute->ExecuteData($cmd);
    //             if(count($result) > 0)
    //             {
    //                 return true;
    //             }
    //             else
    //             {
    //                 http_response_code(401);
    //                 return false;
    //             }
    //         // }
    //     }
    //     http_response_code(401);
    //     return false;
    // }


    private function GetAttributes($method)
    {
        $this->values=[];
        $this->attributes = [];
        $atrs = [];
        $atrs = json_decode($this->GetDBattributes());
        $newatrb = [];
        foreach($atrs as $item => $key)
        {
            if(isset($_POST[$key]))
            {
                if($key!="id")
                {
                    array_push($newatrb, $this->CheckAttributes($key,$this->clean->CleanString($_POST[$key])));
                }
            }
        }
        $variable = "";
        foreach($newatrb as $validate => $key)
        {
            foreach($key as $variable => $val)
            {
                if($val === "sucess")
                {
                    $variable = true;
                }
                else
                {
                    $variable = $key;
                    return $val;
                }
            }
        }
        

        foreach($atrs as $item => $key)
        {
            if(isset($_POST[$key]))
            {
                if($method === "POST")
                {
                    if($key !== "id")
                    {
                        $this->EncriptAttributes($key,$_POST[$key]);
                        array_push($this->attributes, $key);
                    }
                }
                else
                {
                    if($key !== "id")
                    {
                        $this->EncriptAttributes($key,$_POST[$key]);
                    }
                    array_push($this->attributes, $key);
                }
                array_push($this->values, $this->clean->CleanString($_POST[$key]));
            }
        }
        return true;
    }


    private function GetDBattributes()
    {
        $atrb = [];
        $sql = "DESCRIBE $this->model_name";
        $result = $this->builds->ExecuteData($sql);
        foreach($result as $resultado => $key)
        {
            array_push($atrb, $key['Field']);
        }
        return json_encode($atrb);
    }


    private function CheckAttributes($key, $value)
    {
        $validator = new Validators($this->model);
        return $validator->Validate($key, $value);
    }

    private function EncriptAttributes($key, $value)
    {
        $validator = new Validators($this->model);
        $validator->Encrypt($key, $value);
    }

}

?>

