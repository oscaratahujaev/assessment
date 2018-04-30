<?php
/**
 * Created by PhpStorm.
 * User: m_toshpolatov
 * Date: 23.04.2018
 * Time: 10:02
 *
 */
use app\models\Category;
use app\models\District;
use app\models\Quarter;
use app\models\Region;
use app\models\Years;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/**
 *
 * */
$categories = Category::find()->all();
$regions = Region::find()->all();
$district = District::find()->all();
$quarter = Quarter::find()->all();
$year = Years::find()->all();
?>
<p>
    <?php $form = ActiveForm::begin(['method' => 'GET', 'action' => Url::to(['data/table'])]); ?>
    <?= Html::dropDownList('categoryID', $categoryId,
        ArrayHelper::map($categories, 'id', 'name'),
        ['prompt' => 'Select Category', 'class' => 'form-control', 'id' => 'category']); ?>
    <br>

<div>
    <?= Html::dropDownList('regionID', $regionId,
        ArrayHelper::map($regions, 'id', 'name'),
        [
            'prompt' => 'Select Region',
            'class' => 'col-md-3',
            'id' => 'region'
        ]
    ); ?>
    <?= Html::dropDownList('yearID', $yearId,
        ArrayHelper::map($year, 'year', 'year'),
        [
            'prompt' => 'Select Year',
            'class' => 'col-md-3',
            'id' => 'year'
        ]
    ); ?>
    <?= Html::dropDownList('quarterID', $quarterId,
        ArrayHelper::map($quarter, 'id', 'name'),
        [
            'prompt' => 'Select Quarter',
            'class' => 'col-md-3',
            'id' => 'quarter'
        ]
    ); ?>
</div>
<button class="btn btn-success" type="submit">Filter</button>
<?php ActiveForm::end() ?>
</p>
<div>
    <table class="table table-striped">
        <thead>
        <th>Худуд номи</th>
        <?php if (isset($category)): ?>
            <?php foreach ($category['categoryParams'] as $cParam): ?>
                <th>
                    <?= $cParam['name'] ?>
                </th>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Please choose the filters</p>
        <?php endif; ?>
        <td>Score</td>
        </thead>
        <tbody>

        <?php foreach ($data as $item): ?>
            <tr>
                <td><?= $item['place'] ?></td>
                <?php foreach ($item['values'] as $value): ?>
                    <td><?= $value ?></td>

                <?php endforeach; ?>
                <td><?= $item['score'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <p>
        <a class="btn btn-primary" id="addUrl" href="
        <?= Url::to('/data/add?categoryID=' . $categoryId .
            '&regionID=' . $regionId . '&year=' . $yearId . '&quarter=' . $quarterId) ?>">
            ADD</a>
    </p>
</div>
