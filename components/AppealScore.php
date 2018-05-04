<?php
/**
 * Created by PhpStorm.
 * User: a_atahujaev
 * Date: 30.04.2018
 * Time: 11:28
 */

namespace app\components;


class AppealScore extends ScoreCalculation
{
    public function calculate()
    {
        $this->value = (1 - $this->percentage) * 10;
    }

    public function getValue()
    {
        return $this->value > 10 ? 10 : $this->value;
    }
}