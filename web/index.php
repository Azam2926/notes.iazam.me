<?php

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

use yii\helpers\VarDumper;

/**
 * Beauty print $data
 * @param mixed $data
 * @param int $depth
 * @param bool $highlight
 * @return string
 */
function vd($data, $depth = 10, $highlight = true)
{

    VarDumper::dump($data, $depth, $highlight);

}

/**
 * @param mixed $data
 */
function vdd($data)
{
    vd($data);
    die();
}


$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();
