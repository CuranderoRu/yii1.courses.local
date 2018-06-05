<?php
/** @var array $events */
/** @var mixed $date */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'View Tasks: ' . $date;
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'View date';
?>

<p>
    <?= Html::a('Create Task', ['create'], ['class' => 'btn btn-success']) ?>
</p>


<table class="table table-bordered">
    <thead class="thead-light">
    <tr>
        <th scope="col">Дата</th>
        <th scope="col">Событие</th>
        <th scope="col">Описание</th>
    </tr>
    </thead>

    <?php foreach ($events as $event): ?>
        <tr>
            <td class="td-date"><span class="label label-success"><?= $event->date; ?></span></td>
            <td><p>
                    <?= Html::a($event->name,
                        Url::to(['task/view', 'id' => $event->id])) . '<br>'
                    ; ?>
                </p>
            </td>
            <td><p class="small">
                    <?= $event->description ; ?>
                </p>
            </td>
        </tr>
    <?php endforeach; ?>
</table>