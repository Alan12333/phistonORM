<?php
class Validators
{
    protected $model;
    protected $declaredmin =0;
    protected $declaredmax = 0;
    public $alert;
    public $object;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function Validate($attributtes)
    {
        $req = false;
        $min = false;
        $max= false;
        $sizemin =null;
        $sizemax =null;
        $value = false;

        if(method_exists($this->model, "validate") == true)
        {
            $array = $this->model->validate();
            print_r($array);
            foreach ($array as $key => $value) {
                if($attributtes === $key)
                {
                    $separate = explode("|", $value);
                    foreach($separate as $value)
                    {
                        if($value === "required")
                        {
                            $req = $this->requires($key);
                        }
                        else
                        {
                            $separate2 = explode(":", $value); 
                            if($separate2[0] === "min")
                            {
                                $sizemin = $separate2[1];
                                $min = $this->min($separate2[1], $key);
                            }
                            if($separate2[0] === "max")
                            {
                                $sizemax = $separate2[1];
                                $max = $this->max($separate2[1], $key);
                            }
                        }
                    }
                    if($min === true && $max === true && $req === true)
                    {
                        $value =  true;
                    }
                    else
                    {
                        $value = $this->Combinations($min,$sizemin,$max,$sizemax,$req);
                    }
                    $this->Encrypt($attributtes);
                    return $this->ConstructObject($value, $attributtes, $this->model->$attributtes);
                }
                else
                {
                    $this->Encrypt($attributtes);
                    return $this->ConstructObject(true, $attributtes, $this->model->$attributtes);
                }
            }
        }
        else
        {
            $this->Encrypt($attributtes);
            return $this->ConstructObject(true, $attributtes, $this->model->$attributtes);
        }
    }

    private function Combinations($min, $sizemin,  $max, $sizemax,  $req)
    {
        if($min === true && $max === true)
        {
            return true;
        }
        else if($min === true && $req === true)
        {
            return true;
        }
        else if($max === true && $req === true)
        {
            return true;
        }
        else if($req === true && $sizemin === null && $sizemax === null)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    private function Encrypt($atribute)
    {
        if(method_exists($this->model,"Bcrypt")==true)
        {
            $array = $this->model->bcrypt();
            foreach($array as $item)
            {
                if($item == $atribute)
                {
                    $this->model->$item = $this->Bcrypt("alan");
                }
            }
        }
    }

    private function max($value, $attribute)
    {
        $counter = str_split($this->model->$attribute);
        $this->declaredmax = count($counter);
        if($value >= count($counter))
        {
            return true;
        }
        else
        {
            $this->alert = ProcessErrors::displayMessage(6,345,__LINE__);;
            return false;
        }
    }

    private function min($value, $attribute)
    {
        $counter = str_split($this->model->$attribute);
        $this->declaredmin = count($counter);
        if($value <= count($counter))
        {
            return true;
        }
        else
        {
            $this->alert = ProcessErrors::displayMessage(7,345,__LINE__);;
            return false;
        }
    }

    private function requires($atribute)
    {
        if($this->model->$atribute != "")
        {
            return true;
        }
        else
        {
            $this->alert = ProcessErrors::displayMessage(5,345,__LINE__);;
            return false;
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

    private function ConstructObject($value, $atr, $val)
    {
        if($value === true)
        {
            $this->object = [
                "name" => $atr,
                "value"=>$val,
                "status" => "sucess"
            ];
        }
        else
        {
            $this->object = [
                "name" => $atr,
                "value" => $val,
                "status" => $this->alert
            ];
        }
        return $this->object;
    }
}

