<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $tin
 * @property string $pin
 * @property string $phone_number
 * @property string $lastname
 * @property string $firstname
 * @property string $birthdate
 * @property string $fullname
 * @property string $address
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    const STATUS_INACTIVE = 1;


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
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED, self::STATUS_INACTIVE]],

            [['username', 'auth_key', 'password_hash', 'created_at', 'updated_at'], 'required'],

            [['status', 'created_at', 'updated_at'], 'integer'],

            [['phone_number', 'lastname', 'firstname', 'username', 'password_hash', 'password_reset_token', 'email', 'tin', 'pin', 'address'], 'string', 'max' => 255],

            [['password_reset_token'], 'unique'],

            [['firstname', 'birthdate', 'per_adr', 'fullname'], 'safe'],

        ];
    }

    public function loginViaSis($userAttributes)
    {
        $errors = '';

        $this->tin = isset($userAttributes['tin']) ? $userAttributes['tin'] : '';
        $this->pin = isset($userAttributes['pin']) ? $userAttributes['pin'] : '';
        $this->address = isset($userAttributes['per_adr']) ? $userAttributes['per_adr'] : '';
        $this->phone_number = isset($userAttributes['mob_phone_no']) ? $userAttributes['mob_phone_no'] : '';
        $this->username = isset($userAttributes['user_id']) ? $userAttributes['user_id'] : '';
        $this->lastname = isset($userAttributes['sur_name']) ? $userAttributes['sur_name'] : '';
        $this->firstname = isset($userAttributes['first_name']) ? $userAttributes['first_name'] : '';
        $this->birthdate = isset($userAttributes['birth_date']) ? $userAttributes['birth_date'] : '';
        $this->fullname = isset($userAttributes['full_name']) ? $userAttributes['full_name'] : '';

        $this->email = isset($userAttributes['email']) ? $userAttributes['email'] : '';


        $duration = 3600 * 24 * 1; // 1 day

        if ($this->isNewRecord) {
            $this->created_at = time();
        }
        $this->updated_at = time();

        $this->password_hash = md5($this->username);
        $this->auth_key = md5($this->username);

        if (!$this->save()) {
            foreach ($this->getErrors() as $error) {
                $errors .= $error[0] . '<br/>';
            }
            Yii::$app->getSession()->setFlash('error', $errors);
            return false;
        }

//        debug($this);
//        debug(Yii::$app->user->login($this, $duration));
//        exit;

        return Yii::$app->user->login($this, $duration);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
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
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
}
