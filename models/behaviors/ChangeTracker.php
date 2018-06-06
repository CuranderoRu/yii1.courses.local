<?php
/**
 * Created by PhpStorm.
 * User: Sergey
 * Date: 06.06.2018
 * Time: 21:27
 */

namespace app\models\behaviors;


use yii\base\Behavior;

class ChangeTracker extends Behavior
{
    public $created_date;

    public function behaviorSample()
    {
        $b_owner = $this->owner;
        echo 'Just a sample behavior' . $b_owner->name;
    }
}