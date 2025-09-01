<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;
use yii\db\ActiveRecord;

class SignupForm extends Model
{
    public $username;
    public $password;
    public $password_repeat;

    public function rules()
    {
        return [
            [['username', 'password', 'password_repeat'], 'required'],
            // ['username', 'unique', 'targetClass' => 'app\models\User', 'message' => 'This username has already been taken.'],
            [['username', 'password', 'password_repeat'], 'string','min' => 4, 'max' => 32],
            ['password_repeat', 'compare', 'compareAttribute' => 'password']
        ];
    }
    public function signup($attribute = null)
    {
        $user = new User();
        $user->username = $this->username;
        $user->password = \Yii::$app->security->generatePasswordHash($this->password);
        //$user->access_token = \Yii::$app->security->generateRandomString();

        if (User::find()->where(['username' => $user->username])->one() == true)
        {
            \Yii::error(message, "User was not saved!1 ". VarDumper::dumpAsString($user->errors));
            // $this->addError($attribute, 'User with the same username already exists! ');
            return false;
        }

        if($user->save())
        {
            return true;
        }
        
        \Yii::error(message, "User was not saved! ". VarDumper::dumpAsString($user->errors));
        return false;
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
}