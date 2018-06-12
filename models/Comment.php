<?php
/**
 * Created by PhpStorm.
 * User: Sergey
 * Date: 12.06.2018
 * Time: 15:36
 */

namespace app\models;


use app\models\tables\Comments;
use yii\base\Model;
use yii\imagine\Image;
use yii\web\UploadedFile;

class Comment extends Model
{
    /** @var Comments*/
    public $task_id;
    public $user_id;
    public $body;
    public $image_name;
    /** @var UploadedFile*/
    public $image;

    public function rules()
    {
        return [
            [['task_id'], 'required'],
            [['user_id'], 'required'],
            [['image_name'], 'safe'],
            [['body'], 'required'],
            [['image'], 'file', 'extensions' => 'jpg, png'],
        ];
    }

    private function uploadImage()
    {
        $FileName = $this->image->getBaseName() . "." . $this->image->getExtension();
        $fullFileName = "@webroot/img/" . $FileName;
        $this->image->saveAs(\Yii::getAlias($fullFileName));
        Image::thumbnail($fullFileName, 200, 100)
        ->save(\Yii::getAlias('@webroot/img/thumbs/' . $FileName));
    }

    public function write()
    {
        if (!is_null($this->image)){
            $this->image_name = $this->image->name;
            $this->uploadImage();
        }else{
            $this->image_name = "";
        }
        $comments = new Comments([
            'task_id'=>$this->task_id,
            'user_id'=>$this->user_id,
            'body'=>$this->body,
            'image_name'=>$this->image_name,
        ]);

        $comments->save();

    }

}