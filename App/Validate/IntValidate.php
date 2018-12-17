<?php
/**
 * Created by PhpStorm.
 * User: ugurgucer
 * Date: 2018-12-06
 * Time: 22:59
 */

namespace App\Validate;

use App\Core\Validation;

class IntValidate
{
    protected $item;

    public function __construct($item)
    {
        $this->item = $item;
    }

    public function min($length){
        if (Validation::$is_validate)
            Validation::$is_validate = $this->item >= $length;
        return $this;
    }

    public function max($length){
        if (Validation::$is_validate)
            Validation::$is_validate = $this->item <= $length;
        return $this;
    }

    public function run(){
        if(!Validation::$is_validate)
            throw new \Exception($this->item." not valid integer value.");
        return Validation::$is_validate;
    }
}