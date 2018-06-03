<?php

namespace app\models;

use app\models\tables\Users;

class User extends \yii\base\BaseObject implements \yii\web\IdentityInterface
{
    public $id;
    public $username;
    public $password;
    public $authKey;
    public $accessToken;
    public $role_id;

    /*private static $users = [
        '100' => [
            'id' => '100',
            'username' => 'admin',
            'password' => 'admin',
            'authKey' => 'test100key',
            'accessToken' => '100-token',
        ],
        '101' => [
            'id' => '101',
            'username' => 'demo',
            'password' => 'demo',
            'authKey' => 'test101key',
            'accessToken' => '101-token',
        ],
    ];*/


    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        $user = Users::findOne($id);
        if(isset($user)){
            return new static([
                'id' => $id,
                'username' => $user->login,
                'password' => $user->password,
                'authKey' => $user->authKey,
                'accessToken' => $user->accessToken,
                'role_id' => $user->role_id,
            ]);
        }else{
            return null;
        }
        //var_dump($user);
        //return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {

        if($user = Users::findOne(['accessToken'=>$token])){
            return new static([
                'id' => $user->id,
                'username' => $user->login,
                'password' => $user->password,
                'authKey' => $user->authKey,
                'accessToken' => $user->accessToken,
                'role_id' => $user->role_id,
            ]);
        }
        return null;

    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {

        if($user = Users::findOne(['login'=>$username])){
            return new static([
                'id' => $user->id,
                'username' => $user->login,
                'password' => $user->password,
                'authKey' => $user->authKey,
                'accessToken' => $user->accessToken,
                'role_id' => $user->role_id,
            ]);
        }
        return null;

    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }

    /**
     * @return mixed
     */
    public function getRoleId()
    {
        return $this->role_id;
    }

}
