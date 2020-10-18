<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/** @var \common\models\Publication $model */

$this->title = $model->title;

$this->params['breadcrumbs'][] = ['url' => ['publication/index'], 'label' => 'Публикации'];
$this->params['breadcrumbs'][] = $model->title;

echo Html::tag('h1', $model->title);
echo Html::tag('div', $model->content);