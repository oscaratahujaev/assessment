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
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
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
        $scoreValues = Functions::getScore(date('Y'), 1, $regionId);
        $emptyPlaces = Functions::getEmptyPlaces($scoreValues, $regionId);

        if (Yii::$app->request->isAjax) {
            sleep(2);
            return $this->renderAjax('home_scores', [
                'scoreValues' => $scoreValues,
                'emptyPlaces' => $emptyPlaces,
            ]);
        }

        return $this->render('index', [
            'scoreValues' => $scoreValues,
            'emptyPlaces' => $emptyPlaces,
        ]);
    }


    /**
     * Login action.
     *
     * @return Response|string
     */
    //    public function actionLogin()
    //    {
    //        if (!Yii::$app->user->isGuest) {
    //            return $this->goHome();
    //        }
    //
    //        $model = new LoginForm();
    //        if ($model->load(Yii::$app->request->post()) && $model->login()) {
    //            return $this->goBack();
    //        }
    //
    //        $model->password = '';
    //        return $this->render('login', [
    //            'model' => $model,
    //        ]);
    //    }

    /**
     * Logout action.
     *
     * @return Response
     */
//    public function actionLogout()
//    {
//        //        $clientId = Yii::$app->params['clientId'];
//        //        return $this->redirect(Yii::$app->params['logoutUrl'] . "?id=" . $clientId);
//        Yii::$app->user->logout();
//        return $this->goHome();
//    }

    public function beforeAction($action)
    {
        if ($action->id == 'index') {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }


    /**
     * Displays contact page.
     *
     * @return Response|string
     */
//    public function actionContact()
//    {
//        $model = new ContactForm();
//        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
//            Yii::$app->session->setFlash('contactFormSubmitted');
//
//            return $this->refresh();
//        }
//        return $this->render('contact', [
//            'model' => $model,
//        ]);
//    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
