<?php
/**
 * Created by PhpStorm.
 * User: a_atahujaev
 * Date: 30.04.2018
 * Time: 11:28
 */

namespace app\components;


class DefaultScore extends ScoreCalculation
{
    public function calculate()
    {
        $this->value = $this->percentage * 2;
    }
}