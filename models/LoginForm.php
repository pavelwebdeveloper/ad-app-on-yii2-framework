<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\Session;


/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{
    public $saveduserid;
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        } 
        return false;
    }
    
    public function getin()
    {
     $userFound = false;
     $rightCredentials = true;
     $registeredNewUser = false;
     $siteusers = (new \yii\db\Query())
    ->select(['siteuserId', 'username', 'password'])
    ->from('siteuser')
    ->all();
     
     foreach($siteusers as $siteuser){
      if ($siteuser['username'] === $this->username && $siteuser['password'] === md5($this->password))
      {
          $this->login();
          $userFound = true;
      } elseif ($siteuser['username'] === $this->username && $siteuser['password'] !== md5($this->password))
      {
           $this->login();
           $userFound = true;
           $rightCredentials = false;
      }      
     }
     
     if(!$userFound)
     {
      $siteusersAmount = count($siteusers);
     $lastKeyAndTokenNumber = $siteusersAmount + 100;
        
     $siteuser = new Siteuser();
     $siteuser->username = $this->username;
     $siteuser->password = md5($this->password);
     $siteuser->authKey = 'test'.$lastKeyAndTokenNumber.'key';
     $siteuser->accessToken = $lastKeyAndTokenNumber.'-token';
     if ($siteuser->save())
      {
          $this->login();
          return $registeredNewUser = true;
      } else {
      return $registeredNewUser = false;
      }
     } elseif ($userFound && $rightCredentials) {
      return $userFound;
     } else {
      return $rightCredentials;
     }
     
     }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = Siteuser::findByUsername($this->username);
        }

        return $this->_user;
    }
}
