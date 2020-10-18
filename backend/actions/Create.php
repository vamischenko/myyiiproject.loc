<?php

namespace backend\actions;

use Yii;
use yii\db\ActiveRecordInterface;
use yii\web\Response;

/**
 * Class Create
 * @package backend\actions
 */
class Create extends \yii2tech\admin\actions\Create
{

    public $stayAction = 'update';

    /**
     * Creates new record.
     * @return mixed response
     */
    public function run()
    {
        $model = $this->newModel();
        $model->scenario = $this->scenario;

        if ($this->load($model, Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return $this->performAjaxValidation($model);
            }
            if ($model->save()) {
                $this->setFlash($this->flash, ['model' => $model]);
                if (Yii::$app->request->getBodyParam('stay')) {
                    $this->controller->redirect([$this->stayAction, 'id' => $model->getPrimaryKey()]);
                } else {
                    $this->controller->redirect($this->createReturnUrl('index', $model));
                }
            }
        } else {
            $this->loadModelDefaultValues($model);
        }

        return $this->controller->render($this->view, [
            'model' => $model,
        ]);
    }
}
