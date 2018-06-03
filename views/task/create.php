<?php
/** @var \app\models\tables\Task $model */

use \yii\widgets\ActiveForm;
use \yii\helpers\Html;

$form = ActiveForm::begin([
    'id' => 'create_task',
    'options' => [
        'class' => 'form-vertical'
    ]
]);

echo $form->field($model, 'name')->textInput();
echo $form->field($model, 'date')->textInput(['type' => 'date']);
echo $form->field($model, 'description')->textarea();
echo $form->field($model, 'user_id')->textInput();

echo Html::submitButton('Создать', ['class' => 'btn btn-success']);

ActiveForm::end();