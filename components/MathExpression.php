<?php
/**
 * Created by PhpStorm.
 * User: m_toshpolatov
 * Date: 20.04.2018
 * Time: 15:35
 */

namespace app\components;


use yii\base\Exception;

class MathExpression
{
    private $expression;
    private $data_arr;

    public function __construct($expression, $data)
    {
        $this->expression = $expression;
        $this->data_arr = $data;
        $this->result = 0;
    }

    public function calculate()
    {

        try {
            $bracketExists = (stripos($this->expression, '('));

            if ($bracketExists === false) {

                if (stripos($this->expression, '/')) {
                    $arr = explode("/", $this->expression);
                    $prevNumber = $this->getColumnIndex($arr[0]);
                    $nextNumber = $this->getColumnIndex($arr[1]);
                    $this->result = $this->data_arr[$prevNumber] / $this->data_arr[$nextNumber];
                } elseif (stripos($this->expression, '+')) {
                    $arr = explode("+", $this->expression);
                    $prevNumber = $this->getColumnIndex($arr[0]);
                    $nextNumber = $this->getColumnIndex($arr[1]);
                    $this->result = $this->data_arr[$prevNumber] + $this->data_arr[$nextNumber];
                }

            } else {
                $arr = explode("/", $this->expression);
                $number = (int)$arr[1];
                $substr = substr($arr[0], 1, strlen($arr[0]) - 2);
                $elements = explode("+", $substr);
                foreach ($elements as $item) {
                    $index = $this->getColumnIndex($item);
                    $this->result += $this->data_arr[$index];
                }
                $this->result /= $number;
            }
        } catch (Exception $e) {
            $this->result = 0;
        }

    }

    private function getColumnIndex($column)
    {
        preg_match('/[0-9]{1,}/', $column, $tmp);
        return (int)$tmp[0];
    }

    public function getResult()
    {
        return round($this->result, 2);
    }

    public function getScore($percentage)
    {
        return $percentage * 2;
    }

}