<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

/* @var \common\models\Publication $model */
?>

<div class="news-item">
    <p><?= Html::a(Html::encode($model->title), $model->route) ?></p>
</div>