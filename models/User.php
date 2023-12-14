<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id ID
 * @property string $password_hash Пароль
 * @property string $password_reset_token Токен скидування паролю
 * @property string $email E-mail
 * @property string $phone Телефон
 * @property string $first_name Імʼя
 * @property string $middle_name По батькові
 * @property string $last_name Прізвище
 * @property string $company Компанія
 * @property string $website Веб-сайт
 * @property string $comment Коментарі
 * @property string $auth_key Ключ авторизации
 * @property integer $status Статус
 * 
 * @property AuthAssignment[] $authAssignments
 * @property AuthItem[] $itemNames
 */

class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    const STATUS_BANNED = 99;

    public $password;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['password_hash', 'email', 'phone', 'first_name', 'last_name'], 'required'],
            [['password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['phone'], 'string', 'max' => 20],
            [['first_name', 'middle_name', 'last_name', 'company', 'website'], 'string', 'max' => 100],
            [['password'], 'string', 'min' => 4],
            [['comment'], 'string'],
            ['status', 'default', 'value' => self::STATUS_DELETED],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_BANNED, self::STATUS_DELETED]],
            [['password_reset_token'], 'unique'],
            [['email'], 'email'],
            [['email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'auth_key' => 'Ключ авторизації',
            'password' => 'Пароль',
            'password_hash' => 'Пароль',
            'password_reset_token' => 'Токен скидування паролю',
            'email' => 'E-mail',
            'phone' => 'Телефон',
            'first_name' => 'Імʼя',
            'middle_name' => 'По батькові',
            'last_name' => 'Прізвище',
            'company' => 'Компанія',
            'website' => 'Веб-сайт',
            'comment' => 'Коментарі',
            'status' => 'Статус',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::find()->where(['id' => $id])->andWhere(
            [
                'or',
                ['status' => self::STATUS_ACTIVE],
                ['status' => self::STATUS_BANNED]
            ]
        )->one();
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" не впроваджено.');
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::find()->where(['email' => $email])->andWhere(
            [
                'or',
                ['status' => self::STATUS_ACTIVE],
                ['status' => self::STATUS_BANNED]
            ]
        )->one();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Generates password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * {@inheritdoc}
     */
    public function checkEmail()
    {
        $query = User::find()->where(['email' => $this->email])->andWhere(
            [
                'or',
                ['status' => 10],
                ['status' => 99]
            ]
        )->andWhere(['<>', 'id', $this->id]);

        if ($query->count() == 0) {
            return true;
        }
        return false;
    }

    /**
     * Gets query for [[AuthAssignments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthAssignments()
    {
        return $this->hasMany(AuthAssignment::class, ['user_id' => 'id']);
    }
}
