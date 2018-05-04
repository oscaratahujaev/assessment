<div class="menus">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Главная <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="#">Статистика</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link actives" href="/d/add">Добавить</a>
                </li>
                <li class="nav-item">
                    <div id="references" class="dropdown navbar-dropdown">
                        <a class="dropdown nav-link">
                            Махсус имкониятлар
                        </a>
                        <div id="reference-items" class="dropdown-menu dropdown-menu-right">
                            <div class="triangle2"></div>
                            <div class=" dropdown-custom-item">
                                <a href="<?= \yii\helpers\Url::to('/category') ?>">Категории</a>
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
                                <a href="<?= \yii\helpers\Url::to('/data') ?>">Показатели</a>
                            </div>
                            <div class=" dropdown-custom-item">
                                <a href="<?= \yii\helpers\Url::to('/score') ?>">Оценка</a>
                            </div>
                            <div class=" dropdown-custom-item">
                                <a href="<?= \yii\helpers\Url::to('/years') ?>">Года</a>
                            </div>
                            <div class="more_margin"></div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</div>