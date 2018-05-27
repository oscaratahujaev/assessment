<?php
/**
 * Created by PhpStorm.
 * User: a_atahujaev
 * Date: 27.05.2018
 * Time: 16:57
 */
use app\components\Functions;
use app\models\DataStatus;
use yii\helpers\Html;

$dataStatus = DataStatus::findOne([
    'category_id' => $categoryId,
    'year' => $year,
    'quarter' => $quarterId,
]);

?>
<div id="file-box">

    <h5>
        Тасдиқловчи ҳужжат

        <?php if (empty($dataStatus)) { ?>
            <?= Html::a('Юклаш',
                [
                    'file-upload',
                    'categoryId' => $categoryId,
                    'year' => $year,
                    'quarter' => $quarterId
                ], [
                    'class' => 'btn btn-outline-primary'
                ]) ?>
        <?php } else { ?>
            <?= Html::a($dataStatus->filename, ['load-file', 'id' => $dataStatus->id,], [
                'target' => '_blank'
            ]) ?>

            <?= Functions::getButton($dataStatus->status) ?>

        <?php } ?>


    </h5>
</div>



