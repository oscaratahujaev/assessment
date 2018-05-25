<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\LoginAsset;
use yii\helpers\Html;

LoginAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <link rel="icon" href="/img/favicon.png">
</head>

<body>
<?php $this->beginBody() ?>
<div class="CenterFlex">

    <div class="CenterForm">
        <section class="form-simple">

            <!--Form with header-->
            <div class="card">

                <!--Header-->
                <div class="header pt-3 grey lighten-2" style="background-color:#59b1e4 ">
                    <div class="row d-flex justify-content-start">
                        <h4 class="deep-grey-text mt-3 mb-4 pb-1 mx-5">
                            <img src="/img/gerb.png" alt="" style="border-radius:50%;">
                            <div>
                                Ҳудуд раҳбарлари фаолиятини баҳолаш аҳборот тизими
                            </div>

                        </h4>
                    </div>
                </div>

                <?php
                $flashes = Yii::$app->session->getAllFlashes();

                ?>
                <?php if (!empty($flashes)) { ?>
                    <div>
                        <div>
                            <?php foreach ($flashes as $key => $value): ?>
                                <div class="alerts">
                                    <a class="btn btn-<?= $key ?>">
                                        <?= $value ?>
                                    </a>
                                </div>

                            <?php endforeach; ?>

                        </div>
                    </div>
                <?php } ?>
                <?= $content ?>

            </div>
        </section>
    </div>

    <?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>
