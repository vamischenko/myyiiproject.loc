<?php

namespace backend\actions;

use common\models\Author;
use common\models\Rubric;
use yii2tech\admin\actions\Delete;

/**
 * Class DeleteRelation
 * @package backend\actions
 */
class DeleteRelation extends Delete
{
    /**
     * @param $id
     * @return mixed response
     */
    public function run($id)
    {
        /** @var Author|Rubric $model */
        $model = $this->findModel($id);

        if ($model->getPublications()->count() == 0) {
            $model->delete();
        }

        $this->setFlash($this->flash, ['id' => $id, 'model' => $model]);

        return $this->controller->redirect($this->createReturnUrl('index', $model));
    }
}
