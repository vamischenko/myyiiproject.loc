<?php

use yii\data\ActiveDataProvider;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var ActiveDataProvider $dataProvider */
/* @var \common\models\Publication $model */


$this->title = 'Publications';
$this->params['breadcrumbs'][] = $this->title;

echo ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_list',
    'emptyText' => 'Список пуст',
    'layout' => "{pager}\n{summary}\n{items}\n{pager}",
    'summary' => 'Показано {count} из {totalCount}',
]);