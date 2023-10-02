<?php

class Sends
{
    protected $execute;

    protected $token;

    protected $method;

    protected $result;

    protected $values;

    protected $attributes;

    protected $model_name;

    protected $model;

    protected $clean;

    function __construct($method, $model_name, $model)
    {
        $this->clean = new DataClean;
        $this->model = $model;
        $this->method = $method;
        $this->model_name = $model_name;
        $this->execute = new Builds;
    }

    public function Verifymethod()
    {
        if($this->method === "POST")
        {
            // if($this->VerifyToken())
            // {
                return $this->GetAttributes();
            // }
        }
        else if($this->method === "PUT")
        {

        }
        else if($this->method === "DELETE")
        {

        }
    }

    private function VerifyToken()
    {
        if(isset($_POST['token']))
        {
            // if($_POST['token']=== Ses::token())
            // {
            //     return true;
            // }
            // else
            // {
                $token = $_POST['token'];
                $cmd = "SELECT * FROM token WHERE _token='$token'";
                $result = $this->execute->ExecuteData($cmd);
                if(count($result) > 0)
                {
                    return true;
                }
                else
                {
                    http_response_code(401);
                    return false;
                }
            // }
        }
        http_response_code(401);
        return false;
    }


    private function GetAttributes()
    {
        $this->values=[];
        $this->attributes = [];
        $atrs = [];
        $atrs = json_decode($this->GetDBattributes());
        foreach($atrs as $item => $key)
        {
            if(isset($_POST[$key]))
            {
                $this->model->$key = $this->clean->Clean($_POST[$key]);
                $this->CheckAttributes($key, $this->model->$key);
            }
            
            // if(isset($_POST[$key]))
            // {
            //     if($this->model->$key == "")
            //     {
            //         $this->model->$key = $this->clean->Clean($_POST[$key]);
            //         $this->CheckAtributtes($key, $this->model->$key);
            //     }
            //     if(isset($_POST['method']))
            //     {
            //         $method = $_POST['method'];
            //         if($method === "POST" || $method === "DELETE")
            //         {
            //             $this->DefineValues($key);
            //         }
            //         else if($method === "PUT" )
            //         {
            //             $this->DefineValues2($key);
            //         }
            //     }
            //     else{
            //         return "Not typed of HTTP ENTER";
            //     }
            // }
            // else
            // {
            //     if(isset($_POST['method']))
            //     {
            //         $method = $_POST['method'];
            //         if($this->model->$key != "")
            //         {
            //             $this->CheckAtributtes($key, $this->model->$key);
            //             if($method === "POST" || $method === "DELETE")
            //             {
            //                 $this->DefineValues($key);
            //             }
            //             else if($method === "PUT" )
            //             {
            //                 $this->DefineValues2($key);
            //             }
            //         }
            //     }
            //     else{
            //         return "Not typed of HTTP ENTER";
            //     }
            // }
        }
    }


    private function GetDBattributes()
    {
        $atrb = [];
        $sql = "DESCRIBE $this->model_name";
        $result = $this->execute->ExecuteData($sql);
        foreach($result as $resultado => $key)
        {
            array_push($atrb, $key['Field']);
        }
        return json_encode($atrb);
    }

    private function DefineValues2($atrib) //Esta funcion evita que los atributos y valores se dupliquen
    {
        if(in_array($atrib, $this->attributes)==false)
        {
            $this->attributes[] = $atrib;
        }
        
        if(in_array($this->model->$atrib, $this->values)==false)
        {
            $this->values[] =[$atrib => $this->model->$atrib];
        }
    }

    private function DefineValues($atrib) //Esta funcion es para los metodos POST Y DELETE
    {
        if(in_array($atrib, $this->attributes)==false)
        {
            $this->attributes[] = $atrib;
        }
        $this->values[] = $this->model->$atrib;
    }

    private function CheckAttributes($key, $attribute)
    {
        $validator = new Validators($this->model);
        $validator->Validate($key);
    }

}

?>

