<?php

use backend\models\PublicationSearch;
use common\models\Publication;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;
use yii2tech\admin\grid\ActionColumn;

/**
 * @var View $this
 * @var PublicationSearch $searchModel
 * @var ActiveDataProvider $dataProvider
 */

$this->title = 'Новости';

echo GridView::widget(
    [
        'id' => 'publication-grid',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            [
                'attribute' => 'title',
                'value' => function (Publication $model) {
                    return Html::a(
                        $model->title,
                        Yii::$app->urlManagerFrontend->createAbsoluteUrl($model->route),
                        [
                            'target' => '_blank',
                            'data-pjax' => '0',
                            'title' => 'Просмотр на сайте',
                        ]
                    );
                },
                'format' => 'raw'
            ],
            'created_at:datetime',
            [
                'attribute' => 'status_id',
                'value' => function (Publication $model) {
                    return $model->isActive ? Html::tag('span', null, ['class' => 'fa fa-2x fa-check text-success']) : Html::tag('span', null, ['class' => 'fa fa-2x fa-minus text-danger']);
                },
                'filter' => Publication::status(),
                'format' => 'raw'
            ],
            [
                'class' => ActionColumn::class,
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a(
                            '<i class="glyphicon glyphicon-eye-open"></i>',
                            Yii::$app->urlManagerFrontend->createAbsoluteUrl(['publication/view', 'slug' => $model->slug]),
                            ['target' => '_blank']
                        );
                    },
                ]
            ]
        ]
    ]
);
echo $this->render('/blocks/_nav-bar.php', ['buttons' => [
    ['label' => 'Создать', 'url' => ['create']]
]]);
