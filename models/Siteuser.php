<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "siteuser".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $authKey
 * @property string $accessToken
 */
class Siteuser extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'siteuser';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password', 'authKey', 'accessToken'], 'required'],
            [['username'], 'string', 'max' => 25],
            [['password'], 'string', 'max' => 255],
            [['authKey', 'accessToken'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'siteuserId' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'authKey' => 'Auth Key',
            'accessToken' => 'Access Token',
        ];
    }

 public function getAuthKey(): string {
   return $this->authKey;
 }

 public function getId() {
  return $this->siteuserId;
 }

 public function validateAuthKey($authKey): bool {
  return $this->authKey === $authKey;
 }

 public static function findIdentity($id) {
  return self::findOne($id);
 }

 public static function findIdentityByAccessToken($token, $type = null) { 
           return self::findOne(['accessToken' => $token]);
 }
 
 /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return self::findOne(['username' => $username]);
    }
    
    
    public function validatePassword($password)
    {
        return $this->password === md5($password);
    }

}
