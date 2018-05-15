<?php

namespace app\components;

use app\models\District;
use app\models\Region;
use Yii;

/**
 * Created by PhpStorm.
 * User: m_toshpolatov
 * Date: 20.04.2018
 * Time: 15:07
 */
class Functions
{
    public static function getScore($yearId, $quarterId, $regionId = 0)
    {
        $scoreValues = [];
        $connection = Yii::$app->getDb();
        $command = "";
        if ($regionId == 0) {
            $command = $connection->createCommand("
                SELECT  r.name, r.id, SUM(s.value) as score_sum FROM score s
                        JOIN region r ON s.region_id = r.id 
                          WHERE s.quarter_id =" . $quarterId . " AND s.year = " . $yearId . " GROUP BY s.region_id
            ");
        } else {
            $command = $connection->createCommand("
            SELECT s.quarter_id, d.id, d.name, SUM(s.value) 
              as score_sum FROM score s 
                JOIN district d 
                    ON s.district_id = d.id
                      WHERE d.region_id=" . $regionId . " AND s.quarter_id =" . $quarterId . " 
                            AND s.year = " . $yearId . " GROUP BY s.district_id");
        }

        if ($regionId == 0) {
            $data = $command->queryAll();
            foreach ($data as &$item) {
                $numberOfDistricts = District::find()->where(['region_id' => $item['id']])->count('id');
                $item['score_sum'] = ($item['score_sum'] / (float)$numberOfDistricts);
            }
            $scoreValues = $data;
        } else {
            $scoreValues = $command->queryAll();
        }

        return $scoreValues;
    }

    public static function getEmptyPlaces($scoreValues, $regionId)
    {
        $filledPlaces = [];
        foreach ($scoreValues as $value) {
            array_push($filledPlaces, $value['id']);
        }
        if ($regionId > 0) {
            $emptyPlaces = District::find()->where(['region_id' => $regionId])->andWhere(['NOT IN', 'id', $filledPlaces])->all();
        } else {
            $emptyPlaces = Region::find()->where(['NOT IN', 'id', $filledPlaces])->all();
        }

        return $emptyPlaces;
    }

    public static function getUserRole($roleId)
    {
        if ($roleId == 1) {
            return "Маълумот киритувчи";
        } else if ($roleId == 2) {
            return "Администратор";
        } else {
            return null;
        }
    }

}