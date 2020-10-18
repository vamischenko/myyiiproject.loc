<?php

use yii\widgets\ActiveForm;

/**
 * @var common\models\User $model
 * @var yii\web\View $this
 */

$form = ActiveForm::begin();
echo $form->errorSummary($model);

?>

<div class="row">
    <div class="col-lg-4">
        <?= $form->field($model, 'username')->textInput(); ?>
        <?= $form->field($model, 'password')->textInput(); ?>
        <?= $form->field($model, 'name')->textInput(); ?>
        <?= $form->field($model, 'surname')->textInput(); ?>
        <?= $form->field($model, 'status_id')->dropDownList($model::status()); ?>
        <?= $form->field($model, 'role_id')->dropDownList($model::role()); ?>
    </div>
</div>

<?php

echo $this->render('/blocks/_save-bar', ['model' => $model]);
ActiveForm::end();
