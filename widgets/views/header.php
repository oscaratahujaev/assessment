<?php
/**
 * Created by PhpStorm.
 * User: m_toshpolatov
 * Date: 03.05.2018
 * Time: 11:46
 */
use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="header">
    <div class="row">
        <div class="col-md-5">
            <div class="logo_box">
                <a href="<?= Url::to('#') ?>">
                    <img src="/img/Uzb.png">
                    <h5>
                        Информационная система <br>
                        оценки деятельности<br>
                        руководителей регионов
                    </h5>
                </a>
            </div>
        </div>
        <div class="col-md-7">
            <div class="box">
                <div class="dropdown" style="max-width:150px;">
                    <img src="/img/eye.png">
                    <button class="dropdown" data-toggle="dropdown">
                        Махсус имкониятлар
                    </button>
                    <div class="dropdown-menu dropdown-menu-right specialViewArea no-propagation">
                        <div class="triangle2"></div>
                        <div class="appearance">
                            <p class="specialTitle">Ko'rinish</p>

                            <div class="squareAppearances">
                                <div class="squareBox spcNormal" data-toggle="tooltip" data-placement="bottom"
                                     title="" data-original-title="Oddiy ko'rinish">A
                                </div>
                            </div>
                            <div class="squareAppearances">
                                <div class="squareBox spcWhiteAndBlack" data-toggle="tooltip"
                                     data-placement="bottom" title="" data-original-title="Oq-qora ko'rinish">A
                                </div>
                            </div>
                            <div class="squareAppearances">
                                <div class="squareBox spcDark" data-toggle="tooltip" data-placement="bottom"
                                     title="" data-original-title="Qorong'ilangan ko'rinish">A
                                </div>
                            </div>
                        </div>

                        <div class="appearance">
                            <p class="specialTitle">Shirift o'lchami</p>

                            <div class="block">
                                <div class="sliderText"><span class="range">0</span>% ga kattalashtirish</div>
                                <div id="fontSizer"
                                     class="defaultSlider ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all">
                                    <div class="ui-slider-range ui-widget-header ui-corner-all ui-slider-range-min"
                                         style="width: 0%;"></div>
                                    <span c
                                    <dss
                                    ="ui-slider-handle ui-state-default ui-corner-all" tabindex="0" style="left: 0%
                                    ;"></span>
                                    <div class="ui-slider-range ui-widget-header ui-corner-all ui-slider-range-min"
                                         style="width: 0%;"></div>
                                    <div class="ui-slider-range ui-widget-header ui-corner-all ui-slider-range-min"
                                         style="width: 0%;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="more_margin"></div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="enter">
                    <?php if (Yii::$app->user->isGuest): ?>
                        <button type="button" class="btn btn-outline-primary" data-toggle="modal"
                                data-target="#myModal">
                            Войти в кабинет
                        </button>

                        <div class="modal fade" id="myModal">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Рўйхатдан ўтиш</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        <div class="authorization_text">Жамоавий мурожаат яратиш учун Ягона
                                            идентификация тизими (id.gov.uz) орқали авторизациядан ўтишингиз лозим
                                        </div>
                                        <a href="/login" class="register_square">
                                            <img src="/img/oneidBig.png">
                                        </a>
                                    </div>

                                    <!-- Modal footer -->


                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="named__box">
                            <ul>
                                <li><span class="link">MNO</span></li>
                                <li>
                                    <?= Html::a('Чиқиш <span class="link">(' . Yii::$app->user->identity->username . ')</span>',
                                        ['/logout'], [
                                            'style' => 'color:#505355',
                                            'data' => [
                                                'confirm' => Yii::t('main', 'Are you sure you want to delete this item?'),
                                                'method' => 'post',
                                            ],
                                        ]) ?>

                                </li>
                            </ul>
                        </div>
                    <?php endif; ?>

                </div>

            </div>
            <div class="clearfix"></div>
        </div>

    </div>
</div>