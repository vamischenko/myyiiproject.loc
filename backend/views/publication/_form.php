<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/**
 * @var \common\models\Publication $model
 * @var ActiveForm $form
 * @var yii\web\View $this
 */


$form = ActiveForm::begin(['enableClientValidation' => false]);
echo $form->errorSummary($model);

echo $form->field($model, 'title')->textInput();

echo $form->field($model, 'annotation')->textarea(['rows' => 4, 'placeholder' => $model->getAttributeLabel('annotation')]);

echo $form->field($model, 'content')->textarea(['rows' => 10, 'placeholder' => $model->getAttributeLabel('content')]);

echo $this->render('//blocks/_save-bar', [
    'model' => $model
]);

ActiveForm::end();
