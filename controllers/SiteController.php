<?php

namespace app\controllers;

use app\components\Functions;
use app\models\Category;
use app\models\Data;
use Yii;
use yii\base\Exception;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex($regionId = 0)
    {
        $year = date('Y');
        $quarter = 1;
        $scoreValues = Functions::getScore($year, $quarter, $regionId);
        $emptyPlaces = Functions::getEmptyPlaces($scoreValues, $regionId);

        1 == 2 ? (3 == 4 ? true : false) : false;

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('home_scores', [
                'scoreValues' => $scoreValues,
                'emptyPlaces' => $emptyPlaces,
                'year' => $year,
                'quarter' => $quarter,
            ]);
        }

        return $this->render('index', [
            'scoreValues' => $scoreValues,
            'emptyPlaces' => $emptyPlaces,
            'year' => $year,
            'quarter' => $quarter,
        ]);
    }


    /**
     * Login action.
     *
     * @return Response|string
     */

    public function beforeAction($action)
    {
        if ($action->id == 'index') {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

}
