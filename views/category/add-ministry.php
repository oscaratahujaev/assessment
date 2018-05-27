<?php
/**
 * Created by PhpStorm.
 * User: a_atahujaev
 * Date: 27.05.2018
 * Time: 12:33
 */
use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CategoryMinistery */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'ministery_id')->widget(Select2::classname(), [
    'data' => ArrayHelper::map(\app\models\Ministry::find()->all(), 'id', 'name'),
]);
?>

<div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Сақлаш'), ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>

