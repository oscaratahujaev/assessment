<?php

use app\models\Ministry;
use app\models\Region;
use app\models\User;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">

        <?php if ($model->isNewRecord) { ?>
            <div class="col-md-3">
                <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'required' => true,]) ?>
                <?= $form->field($model, 'status')->hiddenInput(['value' => User::STATUS_ACTIVE])->label(false) ?>
            </div>
        <?php } else { ?>
            <div class="col-md-3">
                <?= $form->field($model, 'status')->dropDownList([User::STATUS_INACTIVE => 'Inactive', User::STATUS_ACTIVE => 'Active']) ?>
            </div>
        <?php } ?>
        <div class="col-md-3">
            <?= $form->field($model, 'lastname')->textInput(['maxlength' => true, 'required' => true,]) ?>
        </div>

        <div class="col-md-3">
            <?= $form->field($model, 'firstname')->textInput(['maxlength' => true, 'required' => true,]) ?>
        </div>

        <div class="col-md-3">
            <?= $form->field($model, 'phone_number')->textInput(['maxlength' => true, 'required' => true,]) ?>
        </div>

        <div class="col-md-3">
            <?= $form->field($model, 'region_id')->dropDownList(
                ['' => ''] + ArrayHelper::map(Region::find()->all(), 'id', 'name')
            ) ?>
        </div>

        <div class="col-md-3">
            <?= $form->field($model, 'role')->dropDownList(
                ['' => ''] + User::$roles
            ) ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'ministry_id')->widget(Select2::classname(), [
                'data' => ['' => ''] + ArrayHelper::map(\app\models\Ministry::find()->all(), 'id', 'name'),
            ]);
            ?>
        </div>

        <div class="col-md-3">
            <?= $form->field($model, 'email')->textInput(['required' => true]) ?>
        </div>


    </div>


    <div class="form-group">
        <?= Html::submitButton('Сақлаш', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
