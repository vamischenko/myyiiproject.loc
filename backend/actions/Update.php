<?php

namespace backend\actions;

use Yii;
use yii\web\Response;

/**
 * Class Update
 * @package backend\actions
 */
class Update extends \yii2tech\admin\actions\Update
{
    /**
     * Updates existing record specified by id.
     * @param mixed $id id of the model to be deleted.
     * @return mixed response.
     */
    public function run($id)
    {
        $model = $this->findModel($id);
        $model->scenario = $this->scenario;

        if ($this->load($model, Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return $this->performAjaxValidation($model);
            }

            if ($model->save()) {
                $this->setFlash($this->flash, ['id' => $id, 'model' => $model]);

                if (Yii::$app->request->getBodyParam('stay')) {
                    $this->controller->refresh();
                } else {
                    $this->controller->redirect($this->createReturnUrl('index', $model));
                }
            }
        }

        return $this->controller->render($this->view, [
            'model' => $model,
        ]);
    }
}
