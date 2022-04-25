<?php
namespace app\common\controllers;

use yii\rest\Controller;
use yii\filters\auth\HttpBearerAuth;

class BaseRestController extends Controller
{
    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
        ];
        return $behaviors;
    }
}