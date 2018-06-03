<?php

namespace app\controllers;

use Yii;
use app\models\tables\users;
use app\models\tables\UsersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UnauthorizedHttpException;

/**
 * UserController implements the CRUD actions for users model.
 */
class UserController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all users models.
     * @return mixed
     * @throws UnauthorizedHttpException if the user has no admin rights
     */
    public function actionIndex()
    {

        if(!$this->isAuthorized()){
            throw new UnauthorizedHttpException();
        }


        $searchModel = new UsersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single users model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws UnauthorizedHttpException if the user has no admin rights
     */
    public function actionView($id)
    {

        if(!$this->isAuthorized()){
            throw new UnauthorizedHttpException();
        }


        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new users model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    private function isAuthorized(){
        if(Yii::$app->user->getIdentity()->role_id==0){
            return true;
        }
        return false;

    }

    public function actionCreate()
    {


        if(!$this->isAuthorized()){
            throw new UnauthorizedHttpException();
        }

        $model = new users();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing users model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws UnauthorizedHttpException if the user has no admin rights
     */
    public function actionUpdate($id)
    {

        if(!$this->isAuthorized()){
            throw new UnauthorizedHttpException();
        }

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing users model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws UnauthorizedHttpException if the user has no admin rights
     */
    public function actionDelete($id)
    {

        if(!$this->isAuthorized()){
            throw new UnauthorizedHttpException();
        }


        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the users model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return users the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = users::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
