<?php
/**
 * Created by PhpStorm.
 * User: a_atahujaev
 * Date: 27.05.2018
 * Time: 16:57
 */
use app\models\DataStatus;
use kartik\file\FileInput;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = "Тасдиқловчи хужжат юклаш";
?>
<h4><?= $this->title ?></h4>

<div class="data-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'file')->widget(FileInput::classname());
    ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Сақлаш'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
