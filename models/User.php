<?php

namespace app\models;
use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements \yii\web\IdentityInterface
{
    // public $id;
    // public $username;
    // public $password;
    // public $authKey;
    // public $accessToken;

    // private static $users = [
    //     '100' => [
    //         'id' => '100',
    //         'username' => 'admin',
    //         'password' => 'admin',
    //         'authKey' => 'test100key',
    //         'accessToken' => '100-token',
    //     ],
    //     '101' => [
    //         'id' => '101',
    //         'username' => 'demo',
    //         'password' => 'demo',
    //         'authKey' => 'test101key',
    //         'accessToken' => '101-token',
    //     ],
    // ];

    public function rules()
    {
        return [
            [['username'], 'required'],
            [
                ['username'],
                'unique',
                'targetClass' => self::class,
                'message' => 'This username is already taken.',
            ],
            [['password'], 'required', 'on' => 'create'],
            [['username'], 'string', 'max' => 55],
            [['password'], 'string', 'max' => 255],
            [['role'], 'in', 'range' => ['user', 'admin']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'username' => 'Username',
            'password' => 'Password',
            'role' => 'Role',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();

        if (Yii::$app->user->identity->role === 'admin') {
            $scenarios['default'] = ['username', 'password', 'role'];
        } else {
            $scenarios['default'] = ['username', 'password'];
        }

        return $scenarios;
    }

    public static function findIdentity($id)
    {
        return self::find()->where(['user_id' => $id])->one();
        //return self::findOne($id);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function getPets()
    {
        return $this->hasMany(Pet::class, ['user_id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
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
        return self::findOne(['username' => $username]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->user_id; //field in db
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        // return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        // return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);//$this->password === $password;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            if (!empty($this->password)) {
                $this->password = Yii::$app->security->generatePasswordHash($this->password);
            } else {
                if (!$insert) {
                    $this->password = $this->getOldAttribute('password');
                }
            }

            return true;
        }
        return false;
    }
}
