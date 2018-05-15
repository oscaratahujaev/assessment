<?php
/**
 * Created by PhpStorm.
 * User: m_toshpolatov
 * Date: 14.05.2018
 * Time: 10:36
 */
use yii\helpers\Url;

?>
<div id="home_block"></div>
<div class="inspections-info">
    <div class="inspections-list clearfix">
        <i class="arrow"></i>
        <div>
            <div id="home_score_block">
                <h4 class="text-center"><?= $year ?> йил, <?= $quarter ?>-чорак</h4>
                <div class="row">
                    <?php foreach ($scoreValues as $value): ?>
                        <div class="item col-md-6" style="margin-bottom:20px">
                            <h5><?= $value['name'] ?></h5>
                            <p>Бахо:
                                <span> <?= Yii::$app->formatter->asDecimal($value['score_sum']) ?> / 100</span>
                            </p>
                            <a href="<?= Url::to('score/values?regionId=' . $value['id']) ?>">
                                <span>Батафсил</span>
                            </a>
                        </div>
                    <?php endforeach; ?>
                    <?php foreach ($emptyPlaces as $place): ?>
                        <div class="item col-md-6" style="margin-bottom:20px">
                            <h5><?= $place['name'] ?></h5>
                            <p>Бахо:
                                <span>0 / 100</span>
                            </p>
                            <?php $region_id = isset($place['region_id']) ? $place['region_id'] : $place['id'] ?>
                            <a href="<?= Url::to('score/values?regionId=' . $region_id); ?>">
                                <span>Батафсил</span>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
