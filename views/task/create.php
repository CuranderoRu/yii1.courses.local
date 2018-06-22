<?php
/** @var \app\models\tables\Task $model */
/** @var \yii\web\View $this */

use \yii\widgets\ActiveForm;
use \yii\helpers\Html;

$script = <<<SCRIPT

    $(function () {
        $(".test_btn").on('click', function () {
            console.log("Script execution success");
        });
    });


SCRIPT;

$this->registerJs($script, \yii\web\View::POS_READY);

$this->title = 'Update Task: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Create';


$form = ActiveForm::begin([
    'id' => 'create_task',
    'options' => [
        'class' => 'form-vertical'
    ]
]);

echo $form->field($model, 'name')->textInput();
//echo $form->field($model, 'date')->textInput(['type' => 'date']);
echo $form->field($model, 'date')->widget(\kartik\date\DatePicker::class, [
    'options' => ['placeholder' => 'Start date ...'],
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
    ]
]);
echo $form->field($model, 'description')->textarea();
echo $form->field($model, 'user_id')->textInput();
echo $form->field($model, 'deadline')->widget(\kartik\datetime\DateTimePicker::class, [
    'options' => ['placeholder' => 'Target date ...'],
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd hh:ii:59',
    ]
]);

echo Html::submitButton('Создать', ['class' => 'btn btn-success']);

ActiveForm::end();

echo Html::button('JS test', ['class' => 'test_btn']);
echo Html::button('JS file test', ['class' => 'test_btn1']);
