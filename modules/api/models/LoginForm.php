<?php

namespace app\modules\api\models;

use app\models\LoginForm as Form;
use app\modules\api\resources\UserResource;
use Yii;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Form
{
    /**
     * Finds user by [[username]]
     *
     * @return UserResource|bool
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = UserResource::findByUsername($this->username);
        }

        return $this->_user;
    }
}
