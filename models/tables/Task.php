<?php

namespace app\models\tables;

use Yii;

/**
 * This is the model class for table "task".
 *
 * @property int $id
 * @property string $name
 * @property string $date
 * @property string $description
 * @property int $user_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Users $user
 */
class Task extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'date', 'user_id'], 'required'],
            [['date'], 'safe'],
            [['description'], 'string'],
            [['user_id'], 'integer'],
            [['name'], 'string', 'max' => 250],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'date' => 'Дата исполнения',
            'description' => 'Описание',
            'user_id' => 'Пользователь',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }

    public static function getByCurrentMonth($userId)
    {
        return static::find()
            ->where(['user_id' => $userId])
            ->andWhere(['MONTH(date)' => date('n')])
            ->all();
    }

    public static function getByUserAndDate($userId, $date)
    {
        $timestamp = strtotime($date);
        return static::find()
            ->where(['user_id' => $userId])
            ->andWhere(['YEAR(date)' => date('Y', $timestamp)])
            ->andWhere(['MONTH(date)' => date('n', $timestamp)])
            ->andWhere(['DAY(date)' => date('j', $timestamp)])
            ->all();
    }

}
