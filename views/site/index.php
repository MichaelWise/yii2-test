<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <?php if (Yii::$app->user->getIsGuest())  : ?>
            <p>
                <a class="btn btn-lg btn-success" href="/site/login">Авторизация</a>
                <span class="spacer"></span>
                <a class="btn btn-lg btn-primary" href="/site/signup">Регистрация</a>
            </p>
        <?php endif; ?>
    </div>
</div>
