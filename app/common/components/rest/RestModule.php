<?php
namespace app\common\components\rest;

use Yii;
use yii\web\Response;

class RestModule extends \yii\base\Module
{
    const SUCCESS = 0;
    const FAILED = 1;

    public function init()
    {
        parent::init();
        Yii::$app->user->enableSession = false;
        Yii::$app->setComponents([
            'response' => [
                'class'=>'yii\web\Response',
                'format' =>  Yii::$app->request->headers->get('Accept') == 'application/xml' ? Response::FORMAT_XML : Response::FORMAT_JSON,
                'on beforeSend' => function ($event) {
                    $response = $event->sender;
                    if ($response->data !== null) {
                        $response->data = [
                            'status' => $response->isSuccessful ? self::SUCCESS : self::FAILED,
                            'data' => $response->data,
                        ];
                        unset($response->data['data']['type'],$response->data['data']['code'],$response->data['data']['previous']);
                        $response->statusCode = 200;
                    }
                },
            ],
        ]);
    }
}