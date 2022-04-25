<?php

namespace app\controllers;

use Yii;
use yii\rest\Controller;

class SiteController extends Controller
{

    public function actionError()
    {
        return ['status' => 1, 'message' => 'error'];
    }

}
