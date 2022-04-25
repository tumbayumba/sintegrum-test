<?php

namespace app\modules\v1\controllers;

use app\common\components\parsers\TicketParser;
use app\common\controllers\BaseRestController;
use yii\filters\VerbFilter;

class FlightController extends BaseRestController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'endpoint' => ['POST'],
                ],
            ],
        ];
    }

    public function actionEndpoint()
    {
        $parser = new TicketParser(\Yii::$app->request->post(), TicketParser::XML);

        return $parser->getEndpoint();
    }
}