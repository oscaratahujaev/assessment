<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>
        The above error occurred while the Web server was processing your request.
    </p>
    <p>
        Please contact us if you think this is a server error. Thank you.
    </p>

</div>

<?/*= (Yii::$app->user->isGuest) ?
                    ('<div class="box">
                                   <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                        Войти в кабинет
                                    </button>

                                    <div class="modal fade" id="myModal">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content">

                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Авторизация</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    <div class="authorization_text">Жамоавий мурожаат яратиш учун Ягона идентификация тизими (id.gov.uz) орқали авторизациядан ўтишингиз лозим</div>
                                                    <a href="https://id.gov.uz" class="register_square">
                                                        <img src="img/oneidBig.png">
                                                    </a>
                                                </div>

                                                <!-- Modal footer -->


                                            </div>
                                        </div>
                                    </div> </div>'
                    ) : (
                        '<div class="simple_button"><a>'
                        . Html::beginForm(['/site/logout'], 'post')
                        . Html::submitButton(
                            '<img src="img/exit.png" alt=""> Выход',
                            ['class' => 'logout']
                        )
                        . Html::endForm()
                        . '</a></div>'
                    )*/

?>