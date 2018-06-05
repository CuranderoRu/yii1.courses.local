<?php
/** @var array $tasks */
use yii\helpers\Html;
use yii\helpers\Url;
?>

<p>
    <?= Html::a('Create Task', ['create'], ['class' => 'btn btn-success']) ?>
</p>


<table class="table table-bordered">
    <tr>
        <td>Дата</td>
        <td>Событие</td>
        <td>Всего событий</td>
    </tr>
    <?php foreach ($calendar as $day => $events): ?>
        <tr>
            <td class="td-date"><span class="label label-success"><?= $day; ?></span></td>
            <td>
                <?= (count($events) == 0) ? '<p>-</p>' : ''; ?>
                <?= '<p class="small">'; ?>
                <?php foreach ($events as &$event): ?>

                    <?= Html::a($event->name,
                        Url::to(['task/view', 'id' => $event->id])) . '<br>'
                    ; ?>

                <?php endforeach; ?>
                <?= '</p>'; ?>
            </td>
            <td class="td-event"><?= (count($events) > 0) ? Html::a(count($events),
                    Url::to(['task/events', 'date' => $events[0]->date])) : '-'; ?></td>
        </tr>
    <?php endforeach; ?>
</table>