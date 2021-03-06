<?php

namespace app\controllers;

use app\models\Comment;
use app\models\tables\Comments;
use app\models\tables\Users;
use Yii;
use app\models\tables\Task;
use yii\behaviors\TimestampBehavior;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\Html;
use yii\web\UploadedFile;

/**
 * TaskController implements the CRUD actions for Task model.
 */
class TaskController extends Controller
{

    /**
     * Lists all Task models.
     * @return mixed
     */
    public function actionIndex()
    {
        $userId = \Yii::$app->user->getId();
        $calendar = array_fill_keys(range(1, date("t")), []);

        foreach (Task::getByCurrentMonth($userId) as $task){
            $date = \DateTime::createFromFormat("Y-m-d H:i:s", $task->date);
            $calendar[$date->format("j")][] = $task;
        }

        return $this->render('index', [
            'calendar' => $calendar,
            'table_headers' => [
                'Date' => \Yii::t('app', 'Date'),
                'Event' => \Yii::t('app', 'Event'),
                'Total' => \Yii::t('app', 'Total count'),
            ]
        ]);

    }

    /**
     * Displays a single Task model.
     * @param mixed $date
     * @return mixed
     */
    public function actionEvents($date)
    {
        $events = Task::getByUserAndDate(\Yii::$app->user->getId(), $date);
        return $this->render('events', ['events' => $events, 'date' => $date]);
    }


    /**
     * Displays a single Task model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

        $comment = new Comment();
        $comment->user_id = \Yii::$app->user->getId();
        $comment->task_id = $id;

        if (\Yii::$app->request->isPost){
            $comment->load(\Yii::$app->request->Post());
            $comment->image = UploadedFile::getInstance($comment, 'image');
            $comment->write();
            $comment->body = "";
        }

        $comments = Comments::getByTask($id);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'comment' => $comment,
            'comments' => $comments,
        ]);
    }

    /**
     * Creates a new Task model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Task();

        $model->on(Task::EVENT_AFTER_INSERT, function($event){
            $user = Users::findOne($event->sender->user_id);

            Yii::$app->mailer->compose()
                ->setTo($user->email)
                ->setFrom([$user->email => $user->name])
                ->setSubject('New task created -- ' . $event->sender->name)
                ->setTextBody(Html::a('Task link', ['view', 'id' => $event->sender->id]))
                ->send();
        });

        //$model->attachBehavior('datechange',['class' => TimestampBehavior::class, 'value' => date("Y-m-d H:i:s")]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Task model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $model->attachBehavior('datechange',['class' => TimestampBehavior::class, 'value' => date("Y-m-d H:i:s")]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Task model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Task::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'update', 'view'],
                        'allow' => true,
                        'roles' => ['createTask', 'updateTask', 'manageTasks']
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => ['deleteTask', 'manageTasks']
                    ],

                ],
            ],
            ];
    }


}
