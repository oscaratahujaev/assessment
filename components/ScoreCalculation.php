<?php
/**
 * Created by PhpStorm.
 * User: a_atahujaev
 * Date: 30.04.2018
 * Time: 11:27
 */

namespace app\components;


abstract class ScoreCalculation
{
    protected $value;
    protected $percentage;

    public function __construct($percentage)
    {
        $this->percentage = $percentage;
    }

    abstract function calculate();

    public function getValue()
    {
        return $this->value > 2 ? 2 : $this->value;
    }
}