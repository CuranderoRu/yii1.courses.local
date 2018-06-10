<?php

namespace app\models\tables;
use yii\caching\DbDependency;

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
class Task extends ActiveRecord
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

        $cache = \Yii::$app->redis_cache;
        $key =  'tasklist' . $userId;
        $dependency = new DbDependency();
        $dependency->sql = "SELECT Count(*) FROM task WHERE user_id = :user_id";
        $dependency->params = ['user_id' => $userId];

        if ($cache->exists($key)){
            return $cache->get($key);
        }else{
            $val = static::find()
                ->where(['user_id' => $userId])
                ->andWhere(['MONTH(date)' => date('n')])
                ->all();

            $cache->set($key, $val, 10);


            return $val;
        }


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
