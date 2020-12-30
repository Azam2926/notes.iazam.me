<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;

/**
 * Class User
 * @package app\models
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $access_token
 * @property string $avatar
 */

class User extends ActiveRecord implements IdentityInterface {
    
    
    public function rules()
    {
        return [
            [['file'], 'file']
        ];
    }
    
    public static function tableName() {
        return '{{%users}}';
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id) {
        return self::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        return self::find()->andWhere(['access_token' => $token])->one();
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return ActiveRecord
     */
    public static function findByUsername($username) {
        return self::find()->andWhere(['username' => $username])->one();
    }

    /**
     * {@inheritdoc}
     */
    public function getId() {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey() {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey) {
        return false;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password) {
        return \Yii::$app->security->validatePassword($password, $this->password_hash);
    }
    
    public function uploadAvatar()
    {
        if ($this->validate('file'))
        {
            $path = \Yii::getAlias('@webroot/uploads/images/profiles/');
            if ($this->avatar)
                try {
                    unlink($path . $this->avatar);
                } catch (\Exception $exception) {

                }
        
            $this->avatar = $this->file->baseName . '.' . $this->file->getExtension();
    
            if (!file_exists($path))
                mkdir($path, 0777, true);
            
            $this->file->saveAs($path . $this->avatar);
            return $this->save();
        }
        
        return false;
    }
}
