<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property int $id
 * @property string $username
 * @property string $name
 * @property string $surname
 * @property string $password_hash
 * @property string $auth_key
 * @property string $fullName
 * @property int $role_id
 * @property int $status_id
 * @property int $created_at
 * @property int $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;

    const ROLE_ADMIN = 1;
    const ROLE_JOURNALIST = 2;
    const ROLE_SIMPLE = 3;

    private $_password;

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
//            [['username', 'name', 'surname', 'status_id', 'role_id'], 'required'],
            [['status_id', 'role_id'], 'integer'],
            ['status_id', 'in', 'range' => array_keys(self::status())],
            ['role_id', 'in', 'range' => array_keys(self::role())],
            [['username', 'name', 'surname'], 'string', 'max' => 255],
            ['username', 'match', 'pattern' => '/^[a-z0-9_-]*$/i', 'message' => 'Только английские буквы, цифры тире и подчеркивание'],
            ['username', 'unique'],
            ['password', 'string', 'min' => 6, 'max' => 64],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'username' => 'Логин',
            'password' => 'Пароль',
            'status_id' => 'Активный',
            'role_id' => 'Роль',
        ];
    }

    public static function status()
    {
        return [
            self::STATUS_ACTIVE => 'Активный',
            self::STATUS_DELETED => 'Удален'
        ];
    }

    public static function role()
    {
        return [
            self::ROLE_SIMPLE => 'Пользователь',
            self::ROLE_JOURNALIST => 'Журналист',
            self::ROLE_ADMIN => 'Админ'
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status_id' => self::STATUS_ACTIVE]);
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
        return static::findOne(['username' => $username, 'status_id' => self::STATUS_ACTIVE]);
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
        if (!empty($password)) {
            $this->_password = $password;
            $this->password_hash = Yii::$app->security->generatePasswordHash($password);
        }
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->_password;
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function beforeSave($insert)
    {
        $this->name = ucfirst($this->name);
        $this->surname = ucfirst($this->surname);

        if ($this->auth_key === null) {
            $this->generateAuthKey();
        }

        return parent::beforeSave($insert);
    }

    public function getFullName()
    {
        return "{$this->name} {$this->surname}";
    }
}