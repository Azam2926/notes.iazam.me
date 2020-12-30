<?php

namespace app\modules\api\controllers;

use app\modules\api\models\LoginForm;
use app\modules\api\models\RegisterForm;
use app\modules\api\resources\UserResource;
use Yii;
use yii\filters\Cors;
use yii\rbac\Rule;
use yii\rest\Controller;
use yii\web\UnauthorizedHttpException;
use yii\web\UploadedFile;

/**
 * Default controller for the `api` module
 */
class UserController extends Controller
{

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'corsFilter' => [
                'class' => Cors::class,
            ]
        ]);
    }

    public function actionLogin()
    {

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post(), '') && $model->login())
            return $model->getUser();
//        https://050fbe9d-027e-40d3-9a68-dbf5b7e59a0c.mock.pstmn.io
        \Yii::$app->response->statusCode = 422;

        return [
            'errors' => $model->errors,
        ];
    }

    public function actionRegister()
    {

        $model = new RegisterForm();
        if ($model->load(Yii::$app->request->post(), '') && $model->register())
            return $model->user;

        Yii::$app->response->statusCode = 422;

        return [
            'errors' => $model->errors
        ];
    }

    public function actionData()
    {
        $headers = Yii::$app->request->headers;
        if (!isset($headers['Authorization']))
            throw new UnauthorizedHttpException();

        $accessToken = explode(" ", $headers['Authorization'])[1];
        $user = UserResource::findIdentityByAccessToken($accessToken);
        if (!$user)
            throw new UnauthorizedHttpException();

        return $user;

    }

    public function actionUploadAvatar()
    {
//        return $_FILES;
        if (Yii::$app->request->isPost) {
            $access_token = Yii::$app->request->post('access_token');

            $user = UserResource::findIdentityByAccessToken($access_token);
            $user->file = UploadedFile::getInstanceByName('file');

            if ($user->uploadAvatar())
                return [
                    'status' => true,
                    'message' => 'ok, file uploaded',
                    'avatarUrl' => 'http://localhost:8080/uploads/images/profiles/' . $user->avatar
                ];
            else
                return $user->getErrors();
        }

        return [
            'status' => false,
            'message' => 'request is not a post'
        ];
    }
}
