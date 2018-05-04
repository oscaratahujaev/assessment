<?php
/**
 * Created by PhpStorm.
 * User: a_atahujaev
 * Date: 30.04.2018
 * Time: 11:28
 */

namespace app\components;


class NeedyScore extends ScoreCalculation
{
    public function calculate()
    {
        if ($this->percentage >= 0 && $this->percentage <= 0.05) {

            $this->value = 2;

        } else {

            $this->value = (1 - $this->percentage) * 2;

        }
    }

    public function getValue()
    {
        return $this->value > 2 ? 2 : $this->value;
    }
}