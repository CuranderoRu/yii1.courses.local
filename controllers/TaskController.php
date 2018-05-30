<?php
/**
 * Created by PhpStorm.
 * User: Sergey
 * Date: 25.05.2018
 * Time: 21:29
 */

namespace app\controllers;


use app\models\Test;
use yii\web\Controller;

class TaskController extends Controller
{
    public function actionIndex(){

        $model = new Test();

        $model->load([
            'params'  => [],
            'Test' => ['title' => 'Основная страница таск-трекера','content' => 'Yii2']
        ]);

        //$model -> attributes = ['title' => 'Основная страница таск-трекера','content' => 'Yii2'];

        $model->validate();
        $model->getErrors();

        return $this->render('index', ['title' => $model->title, 'content' => $model->content]);
    }

}