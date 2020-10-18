<?php

namespace backend\actions;

use common\helpers\Dictionary;
use common\models\CreditProgram;
use common\models\CreditProgramVariant;
use consultnn\embedded\AbstractEmbeddedBehavior;
use Yii;
use yii2tech\admin\actions\Action;

/**
 * Class Copy
 * @package backend\actions
 */
class Copy extends Action
{
    public function run($id)
    {
        $model = $this->findModel($id);
        /** @var CreditProgram $newModel */
        $newModel = new $model;
        $newModel->attributes = $model->attributes;
        foreach ($model->behaviors() as $behavior) { // copy embedded documents
            if (is_array($behavior)
                && is_a($behavior['class'], AbstractEmbeddedBehavior::class, true)
            ) {
                $embeddedAttr = $behavior['attribute'];
                $newModel->$embeddedAttr = $model->$embeddedAttr;
            }
        }
        $newModel->name .= '(копия)';
        $newModel->status_id = Dictionary::STATUS_HIDDEN;
        $newModel->priority = false;
        $newModel->url = null;

        if ($newModel->save(false)) {
            if (!empty($model->variants)) {
                foreach ($model->variants as $variant) {
                    /** @var CreditProgramVariant $variantModel */
                    $variantModel = new $variant;
                    $variantModel->attributes = $variant->attributes;
                    $variantModel->program_id = $newModel->id;
                    $variantModel->status_id = Dictionary::STATUS_HIDDEN;
                    $variantModel->save(false);
                }
            }
        }
        return $this->controller->redirect(Yii::$app->request->referrer);
    }
}
