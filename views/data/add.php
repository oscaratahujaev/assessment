<?php

/* @var $this yii\web\View */

use app\models\District;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

$i = 3;
$this->title = 'Маълумотни киритиш';
$districts = District::find()->where(['region_id' => $region_id])->all();
?>
<div class="site-about">

    <h3><?= Html::encode($category['name']) ?></h3>

    <?php $form = ActiveForm::begin(); ?>
    <table class="table">
        <tr>
            <td class="align-bottom">
                Туманлар
                <br>
                <?= Html::dropDownList('districtId', $districtId,
                    ArrayHelper::map($districts, 'id', 'name'),
                    ['prompt' => 'Туманни танланг', 'class' => 'form-control',
                        'id' => 'district', 'required' => true]); ?>
            </td>
            <?php foreach ($data as $key => $item): ?>
                <td class="align-bottom">
                    <?= $item['param']['name'] ?><br>
                    <input type="text" id="data-value" class="form-control" name="<?= $key ?>" required
                           aria-invalid="false">
                </td>
                <?php $i++; ?>
            <?php endforeach; ?>
        </tr>
    </table>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Саклаш'), ['class' => 'btn btn-primary btn-save']) ?>
    </div>
    <?php ActiveForm::end() ?>
</div>

