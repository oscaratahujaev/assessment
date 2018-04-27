<?php

use app\models\Category;
use app\models\District;
use app\models\Quarter;
use app\models\Region;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Score */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="score-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'region_id')->dropDownList(ArrayHelper::map(Region::find()->all(), 'id', 'name')); ?>

    <?= $form->field($model, 'district_id')->dropDownList(ArrayHelper::map(District::find()->all(), 'id', 'name')); ?>

    <?= $form->field($model, 'quarter_id')->dropDownList(ArrayHelper::map(Quarter::find()->all(), 'id', 'name')); ?>

    <?= $form->field($model, 'category_id')->dropDownList(ArrayHelper::map(Category::find()->all(), 'id', 'name')); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
