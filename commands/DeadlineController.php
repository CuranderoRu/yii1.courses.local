<?php
/**
 * Created by PhpStorm.
 * User: Sergey
 * Date: 17.06.2018
 * Time: 21:01
 */

namespace app\commands;


use app\models\tables\Task;
use app\models\tables\Users;
use yii\console\Controller;
use yii\helpers\Html;

class DeadlineController extends Controller
{
    /**
     * Notifies users about tasks with 3 day deadline
     */
    public function actionNotify()
    {
        foreach (Task::getByDeadline(3) as $task){
            $user = Users::findOne($task['user_id']);
            if (!is_null($user)){
                \Yii::$app->mailer->compose()
                    ->setTo($user->email)
                    ->setFrom([$user->email => $user->name])
                    ->setSubject('Deadline is coming -- ' . $task['name'])
                    ->setTextBody(Html::a('Task link', ['view', 'id' => $task['id']]))
                    ->send();

            }
        }
    }
}