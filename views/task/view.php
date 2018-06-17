<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use \yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\tables\Task */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'label' => 'Название задачи',
                'value' => $model->name
            ],
            'date',
            'description:html',
            'user_id',
            'created_at',
            'updated_at',
            'deadline'
        ],
    ]) ?>

</div>
<h2>Добавить комментарий:</h2>
<div>
<?php $form = ActiveForm::begin();
echo $form->field($comment, 'body')->textarea();
echo $form->field($comment, 'image')->fileInput();
echo \yii\helpers\Html::submitButton();
\yii\widgets\ActiveForm::end(); ?>



</div>
<h2>Все комментарии:</h2>
<div>
    <table class="table table-bordered">
        <tr>
            <td>Дата</td>
            <td>Пользователь</td>
            <td>Комментарий</td>
            <td>Картинка</td>
        </tr>
        <?php foreach ($comments as $comment): ?>
            <tr>
                <td class="td-date"><span class="label label-success"><?= $comment->created_at; ?></span></td>
                <td class="td-event"><span class="label label-success"><?= $comment->user_id; ?></span></td>
                <td class="td-event"><span class="label label-success"><?= $comment->body; ?></span></td>
                <td class="td-event"><?= Html::img('@web/img/thumbs/' . $comment->image_name, ['alt' => $comment->image_name]); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>