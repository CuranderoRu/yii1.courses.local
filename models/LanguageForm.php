<?php

namespace app\models;

use app\models\tables\Users;
use yii\base\Model;

class LanguageForm extends Model
{
    public $locale;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['locale',], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return ['locale'=>'Language'];
    }

    public function save()
    {
        if (is_null($this->locale)){
            return false;
        }else{
            $_SESSION["locale"] = $this->locale;
            if (!\Yii::$app->user->isGuest) {
                $user = Users::findOne(\Yii::$app->user->getId());
                $user->locale = $this->locale;
                $user->save();
            }
            return true;
        }

    }

}
