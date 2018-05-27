<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'Кириш';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="mx-4 mt-4">
    <div class="md-form">
        <div class="login__section">

            <section id="tabs">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 ">
                            <nav>
                                <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab"
                                       href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Логин/парол</a>
                                    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab"
                                       href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">id.gov.uz</a>
                                </div>
                            </nav>
                            <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                                     aria-labelledby="nav-home-tab">
                                    <p>
                                        Тизимга кириш учун администратордан логин/парол олиш талаб этилади
                                    </p>

                                    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                                    <div class="md-form">
                                        <?= Html::textInput('LoginForm[username]', '', [
                                            'id' => 'usernameId',
                                            'class' => 'form-control',
                                            'autocomplete' => "off",
                                        ]) ?>
                                        <label for="usernameId"><?= Yii::t('main', 'Логин') ?></label>
                                    </div>

                                    <div class="md-form">
                                        <?= Html::passwordInput('LoginForm[password]', '', [
                                            'id' => 'passwordId',
                                            'class' => 'form-control',
                                        ]) ?>
                                        <label for="passwordId"><?= Yii::t('main', 'Парол') ?></label>
                                    </div>
                                    <br>

                                    <div class="form-container">
                                        <div>
                                            <div class="text-center">
                                                <button type="submit"
                                                        class="btn btn-success btn-block z-depth-2 my-button">
                                                    Войти
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <?php ActiveForm::end(); ?>

                                </div>
                                <div class="tab-pane fade" id="nav-profile" role="tabpanel"
                                     aria-labelledby="nav-profile-tab">
                                    <p>
                                        Тизимга кириш учун Ягона идентификация тизими (id.gov.uz) орқали авторизациядан
                                        ўтишингиз лозим
                                    </p>
                                    <br>
                                    <div class="form-container">
                                        <div>
                                            <div class="text-center mb-4">
                                                <a href="/login" class="btn btn-success btn-block z-depth-2 my-button">Кириш</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
        </div>

    </div>


</div>



