<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\User;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Console;


class AppController extends Controller
{

    public function actionIndex()
    {

    }


    public function actionAddUser($username, $password)
    {
        $security = \Yii::$app->security;

        $user = new User();
        $user->username = $username;
        $user->password_hash = $security->generatePasswordHash($password);
        $user->access_token = $security->generateRandomString(255);
        if ($user->save())
            Console::output('ok');
        else {
            Console::output('not ok');
            print_r($user->errors);
        }

    }

    public function actionIndex1()
    {

        $query = 'created_at';
        if ($query[0] === '-') {
            $sortBy = substr($query, 1);
            $sortType = SORT_DESC;
        } else {
            $sortBy = $query;
            $sortType = SORT_ASC;
        }
        print_r([$sortBy => $sortType]);
        print_r($query);
    }
}
