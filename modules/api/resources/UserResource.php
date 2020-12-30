<?php


namespace app\modules\api\resources;


use app\models\User;
use http\Url;
use yii\web\UploadedFile;

class UserResource extends User {
    
    /**
     * @var UploadedFile
     */
    public $file;
    public $avatarUrl;
    
    public function fields() {
        return ['id', 'username', 'access_token', 'avatar', 'avatarUrl'];
    }
    
    public function afterFind()
    {
        $this->avatarUrl =  \yii\helpers\Url::base(true) . '/uploads/images/profiles/' . $this->avatar;
    }
    
}