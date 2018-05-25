<?php
/**
 * Created by PhpStorm.
 * User: Sergey
 * Date: 25.05.2018
 * Time: 22:00
 */

namespace app\models;


use yii\base\Model;

class Test extends Model
{
    public $title;
    public $content;



    public function rules()
    {
        return [
            [['title', 'content'], 'required'],
            [['title'], 'titleValidation'],
            [['content'], 'string', 'max' => 200],
        ];
    }

    public function titleValidation($attribute, $params)
    {
        if ($this->$attribute != 'Основная страница таск-трекера'){
            $this->addError($attribute, "Неверно указан заголовок");
        }
    }

}