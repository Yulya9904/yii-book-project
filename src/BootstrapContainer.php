<?php

declare(strict_types=1);

namespace app;

use app\services\SmsService;
use Yii;
use yii\base\BootstrapInterface;

class BootstrapContainer implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $container = Yii::$container;
        $container->setSingleton(SmsService::class, [], [
            'apiKey' => getenv('SMS_PILOT_API_KEY'),
            'sender' => getenv('SMS_PILOT_SENDER'),
        ]);
    }
}
