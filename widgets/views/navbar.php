<?php
use app\models\User;

$path = '/' . Yii::$app->controller->id . "/" . Yii::$app->controller->action->id;
?>

<div class="menus">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a id="hello" class="nav-link <?= $path === '/site/index' ? 'actives' : '' ?>"
                       href="<?= \yii\helpers\Url::to("/") ?>">Бош саҳифа<span
                                class="sr-only">(current)</span></a>
                </li>
                <?php if (User::can(User::USER_SIMPLE)): ?>
                    <li class="nav-item">
                        <a class="nav-link <?= $path === '/score/values' ? 'actives' : '' ?>"
                           href="<?= \yii\helpers\Url::to('/score/values') ?>">Баҳолар</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $path === '/data/statistics' ? 'actives' : '' ?>"
                           href="<?= \yii\helpers\Url::to('/data/statistics') ?>">Статистика</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $path === '/data/table' ? 'actives' : '' ?>"
                           href="<?= \yii\helpers\Url::to('/data/table') ?>">Маълумотни киритиш</a>
                    </li>
                <?php endif; ?>
                <?php if (User::can(User::USER_ADMIN)): ?>
                    <li class="nav-item">
                        <div id="references" class="dropdown navbar-dropdown">
                            <a class="dropdown nav-link">
                                Маълумотномалар
                            </a>
                            <div id="reference-items" class="dropdown-menu dropdown-menu-right">
                                <div class="triangle2"></div>
                                <div class=" dropdown-custom-item">
                                    <a href="<?= \yii\helpers\Url::to('/category') ?>">Категория</a>
                                </div>
                                <div class=" dropdown-custom-item">
                                    <a href="<?= \yii\helpers\Url::to('/category-params') ?>">Параметры</a>
                                </div>
                                <div class=" dropdown-custom-item">
                                    <a href="<?= \yii\helpers\Url::to('/param-type') ?>">Типы параметров</a>
                                </div>
                                <div class=" dropdown-custom-item">
                                    <a href="<?= \yii\helpers\Url::to('/quarter') ?>">Квартал</a>
                                </div>
                                <div class=" dropdown-custom-item">
                                    <a href="<?= \yii\helpers\Url::to('/ministry') ?>">Министерства</a>
                                </div>
                                <div class=" dropdown-custom-item">
                                    <a href="<?= \yii\helpers\Url::to('/region') ?>">Регионы</a>
                                </div>
                                <div class=" dropdown-custom-item">
                                    <a href="<?= \yii\helpers\Url::to('/district') ?>">Районы</a>
                                </div>
                                <div class=" dropdown-custom-item">
                                    <a href="<?= \yii\helpers\Url::to('/years') ?>">Года</a>
                                </div>
                                <div class="more_margin"></div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
</div>