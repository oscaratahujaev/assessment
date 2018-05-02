<?php
/**
 * Created by PhpStorm.
 * User: a_atahujaev
 * Date: 30.04.2018
 * Time: 11:28
 */

namespace app\components;


class NewEnterpriseScore extends ScoreCalculation
{
    public function calculate()
    {
        if ($this->percentage >= 0.15) {
            $this->value = 2;
        } elseif ($this->percentage >= 0.10 && $this->percentage < 0.15) {
            $this->value = 1.5;
        } elseif ($this->percentage >= 0.05 && $this->percentage < 0.10) {
            $this->value = 1;
        } elseif ($this->percentage < 0.05) {
            $this->value = 0.5;
        }
    }

    public function getValue()
    {
        return $this->value > 2 ? 2 : $this->value;
    }
}