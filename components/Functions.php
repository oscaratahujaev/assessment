<?php

namespace app\components;
/**
 * Created by PhpStorm.
 * User: m_toshpolatov
 * Date: 20.04.2018
 * Time: 15:07
 */
class Functions
{
    static function debug($value)
    {
        echo '<pre>';
        var_dump($value);
        echo '</pre>';
    }
}