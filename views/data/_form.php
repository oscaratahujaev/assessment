<?php

use app\models\Category;
use app\models\CategoryParams;
use app\models\District;
use app\models\Quarter;
use app\models\Region;
use app\models\Years;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Data */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="data-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'region_id')->dropDownList(ArrayHelper::map(Region::find()->all(), 'id', 'name')); ?>

    <?= $form->field($model, 'district_id')->dropDownList(ArrayHelper::map(District::find()->all(), 'id', 'name')); ?>

    <?= $form->field($model, 'category_id')->dropDownList(ArrayHelper::map(Category::find()->all(), 'id', 'name')); ?>

    <?= $form->field($model, 'param_id')->dropDownList(ArrayHelper::map(CategoryParams::find()->all(), 'id', 'name')) ?>

    <?= $form->field($model, 'value')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'quarter')->dropDownList(ArrayHelper::map(Quarter::find()->all(), 'id', 'name')); ?>

    <?= $form->field($model, 'year')->dropDownList(ArrayHelper::map(Years::find()->all(), 'year', 'year')); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Сақлаш'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
