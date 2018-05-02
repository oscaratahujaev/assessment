<?php
/**
 * Created by PhpStorm.
 * User: a_atahujaev
 * Date: 30.04.2018
 * Time: 11:28
 */

namespace app\components;


class WorkplaceScore extends ScoreCalculation
{
    public function calculate()
    {
        if ($this->percentage < 2) {
            $this->value = 2;
        } elseif ($this->percentage >= 2 && $this->percentage < 4) {
            $this->value = 1.5;
        } elseif ($this->percentage >= 4 && $this->percentage < 6) {
            $this->value = 1;
        } elseif ($this->percentage >= 6) {
            $this->value = 0.5;
        }
    }

    public function getValue()
    {
        return $this->value > 2 ? 2 : $this->value;
    }
}