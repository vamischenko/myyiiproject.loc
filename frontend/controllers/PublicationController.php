<?php


namespace frontend\controllers;

use common\models\Publication;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class PublicationController extends Controller
{
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Publication::find()
                ->andWhere(['status_id' => Publication::STATUS_PUBLISHED]),
            'sort' => [
                'defaultOrder' => ['published_at' => SORT_DESC]
            ],
            'pagination' => [
                'defaultPageSize' => 20,
            ],
        ]);
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionView($slug)
    {
        /** @var Publication $model */
        $model = Publication::find()->andWhere(['slug' => $slug])->one();
        if (!$model) {
            throw new NotFoundHttpException();
        }

        if (Yii::$app->request->pathInfo !== ltrim(Url::to($model->route), '/')) {
            return $this->redirect($model->route, 301);
        }

        return $this->render('view', ['model' => $model]);
    }
}