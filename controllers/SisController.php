<?php
/**
 * Created by PhpStorm.
 * User: a_atahujaev
 * Date: 11.07.2017
 * Time: 10:36
 */

namespace app\controllers;


use app\models\User;
use Yii;
use yii\web\Controller;

class SisController extends Controller
{
    public function actionSignup($code)
    {
        $authorizationurl = "https://sso.gov.uz:8443/sso/oauth/Authorization.do";

        $params = Yii::$app->params;
        $clientid = $params['clientId'];
        $scope = $params['scope'];
        $clientsecret = $params['token'];

        $authCode = $_GET["code"];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $authorizationurl);
        curl_setopt($ch, CURLOPT_POST, true);

        $param = "grant_type=" . rawurlencode('one_authorization_code');
        $param = $param . "&client_id=" . rawurlencode($clientid);
        $param = $param . "&client_secret=" . rawurlencode($clientsecret);
        $param = $param . "&code=" . rawurlencode($authCode);
        $param = $param . "&scope=" . rawurlencode($scope);
        $param = $param . "&redirect_uri=" . rawurlencode("");

        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $result = curl_exec($ch);
        curl_close($ch);

        $obj = json_decode($result);

        $access_token = $obj->{'access_token'};

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $authorizationurl);
        curl_setopt($ch, CURLOPT_POST, true);

        $param = "grant_type=" . rawurlencode('one_access_token_identify');
        $param = $param . "&client_id=" . rawurlencode($clientid);
        $param = $param . "&client_secret=" . rawurlencode($clientsecret);
        $param = $param . "&scope=" . rawurlencode($scope);
        $param = $param . "&access_token=" . rawurlencode($access_token);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $results = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($results);

        $response = get_object_vars($response);

//        debug($response);
//        exit;

        if (isset($response['error'])) {
            Yii::$app->getSession()->setFlash('error', 'Авторизация временное не работает. Попробуйте повторить попытку через некоторое время.');
            return $this->redirect(['/']);
        }

        $user = User::findOne(['pin' => $response['pin']]);
        if ($user == null) {
            $user = new User();
        }

        if ($user->loginViaSis($response)) {
            Yii::$app->getSession()->setFlash('success', 'Вы успешно прошли авторизацию.');
            return $this->goHome();
        }

        return $this->redirect('/');

    }


    public function actionLogin()
    {
        return $this->render('login');
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        $clientId = Yii::$app->params['clientId'];

        //        header("Location:" . "https://sso.gov.uz:8443/sso/svc/tk/SLOUzb.do?id=imtiyozliuy.uz");
        //        return;

        return $this->redirect(Yii::$app->params['logoutUrl'] . "?id=" . $clientId);
    }

}