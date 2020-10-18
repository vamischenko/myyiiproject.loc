<?php


namespace backend\actions;

use Yii;
use yii\web\BadRequestHttpException;
use yii2tech\admin\actions\Action;

class Set extends Action
{
    /**
     * Updates existing record specified by id.
     * @param mixed $id id of the model to update.
     * @return mixed response.
     */
    public function run(int $id)
    {
        $model = $this->findModel($id);

        Yii::$app->response->format = Yii::$app->response::FORMAT_JSON;

        if (!$model) {
            Yii::$app->response->statusCode = 404;
            return ['error' => 'объект не найден'];
        }

        $data = Yii::$app->request->post();
        $formName = isset($data[$model->formName()]) ? $model->formName() : '';

        if (!$model->load($data, $formName)) {
            throw new BadRequestHttpException;
        }

        if (!$model->save()) {
            Yii::$app->response->statusCode = 400;
            $errors = $model->errors;
            return ['errors' => $errors];
        }

        return true;
    }
}