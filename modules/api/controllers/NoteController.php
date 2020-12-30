<?php

namespace app\modules\api\controllers;

use app\modules\api\resources\NoteResource;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\Cors;
use yii\rest\ActiveController;

class NoteController extends ActiveController
{
    public $modelClass = NoteResource::class;
    
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        
        $auth = $behaviors['authenticator'];
        $auth['authMethods'] = [
            HttpBearerAuth::class
        ];
        unset($behaviors['authenticator']);
        $behaviors['cors'] = [
            'class' => Cors::class
        ];
        $behaviors['authenticator'] = $auth;
        
        return $behaviors;
        
    }
    
    public function actions()
    {
        $actions = parent::actions();
        
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        
        return $actions;
    }
    
    public function prepareDataProvider()
    {
        $sort_order = [];
        if($query = \Yii::$app->request->getQueryParam('sort'))
        {
            if ($query[0] === '-') {
                $sortBy = substr($query, 1);
                $sortType = SORT_DESC;
            } else {
                $sortBy = $query;
                $sortType = SORT_ASC;
            }

            $sort_order[$sortBy] = $sortType;
        }



        return new ActiveDataProvider([
            'query' => $this->modelClass::find()->andWhere(['created_by' => \Yii::$app->user->id])->orderBy($sort_order)
        ]);
    }
    
}