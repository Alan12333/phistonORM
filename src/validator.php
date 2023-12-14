<?php
class Validators
{
    protected $model;
    protected $declaredmin =0;
    protected $declaredmax = 0;
    public $alert;
    public $object;
    protected $lang;

    public function __construct($model)
    {
        $this->model = $model;
        $this->lang = new Lang("en");
    }

    public function Validate($atrb, $value)
    {
        $req = false;
        $min = false;
        $max= false;
        $atributes = [];
        if(method_exists($this->model, "validate") == true)
        {
            $array = $this->model->validate();
            foreach ($array as $key => $values) {
                if($atrb === $key)
                {
                    $separate = explode(",", $values);
                    foreach($separate as $values2)
                    {
                        if($values2 === "required")
                        {
                            $req = $this->requires($key);
                            if($req === true)
                            {
                                array_push($atributes, "sucess");
                            }
                            else
                            {
                                array_push($atributes, $key." ".$req);
                            }
                        }
                        else
                        {
                            $separate2 = explode(":", $values2); 

                            if($separate2[0] === "min")
                            {
                                $min = $this->min($separate2[1], $key);
                                if($min === true)
                                {
                                    array_push($atributes, "sucess");
                                }
                                else
                                {
                                    array_push($atributes, $key." ".$min);
                                }
                            }

                            if($separate2[0] === "max")
                            {
                                $max = $this->max($separate2[1], $key);
                                if($max === true)
                                {
                                    array_push($atributes, "sucess");
                                }
                                else
                                {
                                    array_push($atributes, $key." ".$max);
                                }
                            }

                            if($separate2[0] === "Int")
                            {
                                $int = $this->checkInt($key);
                                if($int === true)
                                {
                                    array_push($atributes, "sucess");
                                }
                                else
                                {
                                    array_push($atributes, $key." ".$int);
                                }
                            }

                            if($separate2[0] === "Float")
                            {
                                $float = $this->checkFloat($key);
                                if($float === true)
                                {
                                    array_push($atributes, "sucess");
                                }
                                else
                                {
                                    array_push($atributes, $key." ".$float);
                                }
                            }

                            if($separate2[0] === "Mail")
                            {
                                $mail = $this->checkMail($key);
                                if($mail === true)
                                {
                                    array_push($atributes, "sucess");
                                }
                                else
                                {
                                    array_push($atributes, $key." ".$mail);
                                }
                            }

                            if($separate2[0] === "Boolean")
                            {
                                $bool = $this->checkBoolean($key);
                                if($bool === true)
                                {
                                    array_push($atributes, "sucess");
                                }
                                else
                                {
                                    array_push($atributes, $key." ".$bool);
                                }
                            }
                        }
                    }
                }
            }
        }
        return $atributes;
    }

    public function Encrypt($atribute)
    {
        if(method_exists($this->model,"Bcrypt")==true)
        {
            $array = $this->model->bcrypt();
            foreach($array as $item)
            {
                if($item == $atribute)
                {
                    $_POST[$atribute] = $this->Bcrypt($item);
                }
            }
        }
    }

    private function max($value, $attribute)
    {
        $counter = str_split($_POST[$attribute]);
        $this->declaredmax = count($counter);
        if($value >= count($counter))
        {
            return true;
        }
        else
        {
            return $this->lang->ReturnMessage(5);
        }
    }

    private function min($value, $attribute)
    {
        $counter = str_split($_POST[$attribute]);
        $this->declaredmin = count($counter);
        
        if($value <= count($counter))
        {
            return true;
        }
        else
        {
            return $this->lang->ReturnMessage(6);
        }
    }

    private function checkInt($key)
    {
        if(filter_var($_POST[$key], FILTER_VALIDATE_INT) !== false)
        {
            return true;
        }
        else
        {
            return $this->lang->ReturnMessage(1);
        }
    }

    private function checkFloat($key)
    {
        if(filter_var($_POST[$key], FILTER_VALIDATE_FLOAT) !== false)
        {
            return true;
        }
        else
        {
            return $this->lang->ReturnMessage(2);
        }
    }

    private function checkMail($key)
    {
        if(filter_var($_POST[$key], FILTER_VALIDATE_EMAIL) !== false)
        {
            return true;
        }
        else
        {
            return $this->lang->ReturnMessage(0);
        }
    }

    private function checkBoolean($key)
    {
        if(filter_var($_POST[$key], FILTER_VALIDATE_BOOLEAN) !== false)
        {
            return true;
        }
        else
        {
            return $this->lang->ReturnMessage(3);
        }
    }

    private function requires($value)
    {
        if($_POST[$value] === "" || $_POST[$value] === null)
        {
            return $this->lang->ReturnMessage(4);
        }
        else
        {
            return true;
        }
    }


    private function Bcrypt($password)
    {
        $prepare = hash_hmac("sha256",$password,"F#s45-S4#ddsDX12");
        $timewait = 0.5;
        $cost = 10;
        $rand = rand(0,250);
        $options = array([
            'cost'=>$cost,
        ]);
        $hash = password_hash($prepare,PASSWORD_BCRYPT,$options);
        return $hash;
    }

    
}

