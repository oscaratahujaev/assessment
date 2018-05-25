<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'Кириш';
$this->params['breadcrumbs'][] = $this->title;
?>


<?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

<div class="card-body mx-4 mt-4">
    <div class="md-form">

    </div>

    <div class="md-form pb-3" style="margin-bottom:40px;">
        Тизимга кириш учун Ягона идентификация тизими (id.gov.uz) орқали авторизациядан ўтишингиз лозим
    </div>

    <div class="form-container">
        <div>
            <div class="text-center mb-4">
                <a href="/login" class="btn btn-success btn-block z-depth-2 my-button">Кириш</a>
            </div>
        </div>
    </div>
</div>


<?php ActiveForm::end(); ?>
