<?php

namespace app\controllers;

use app\components\Functions;
use app\models\LoginForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex($regionId = 0)
    {
        $this->layout = 'home';
        $year = date('Y');
        $quarter = 1;
        $scoreValues = Functions::getScore($year, $quarter, $regionId);
        $emptyPlaces = Functions::getEmptyPlaces($scoreValues, $regionId);

        1 == 2 ? (3 == 4 ? true : false) : false;

        if (Yii::$app->request->isAjax) {
            sleep(1);
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

    public function actionLogin()
    {
        $this->layout = "login";
        $form = new LoginForm();
        $request = Yii::$app->request;

        if ($request->post()) {
//            debug($request->post());
//            debug($form->load($request->post()));
//            debug($form->login());
//            debug($form->validate());
//            debug($form->getErrors());
//            exit;
        }

        if ($form->load(Yii::$app->request->post()) && $form->login()) {
            return $this->goHome();
        }

        return $this->render('login');

    }

}
