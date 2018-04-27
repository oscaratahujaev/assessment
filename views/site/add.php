<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($category['name']) ?></h1>
    <pre>
<!--    --><?php
        //    var_dump($data);
        //    ?>
        </pre>
    <?php foreach ($data as $item): ?>
        <p>
            <?= $item['param']['name'] ?><br>
            <?= Html::input('value') ?>
        </p>
    <?php endforeach; ?>
</div>
