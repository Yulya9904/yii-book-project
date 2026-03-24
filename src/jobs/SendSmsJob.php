<?php

namespace app\jobs;

use app\services\SmsService;
use Yii;
use yii\base\BaseObject;
use yii\queue\JobInterface;
use yii\queue\Queue;

class SendSmsJob extends BaseObject implements JobInterface
{
    public string $phone;
    public string $message;

    public int $attempt = 1;
    public int $maxAttempts = 3;

    public function execute($queue): void
    {
        $smsService = Yii::$app->get(SmsService::class);
        try {
            $result = $smsService->send($this->phone, $this->message);
            if (!$result) {
                throw new \Exception('SMS sending failed');
            }
            Yii::info("SMS sent to {$this->phone}", 'sms');
        } catch (\Throwable $e) {
            Yii::error([
                'message' => $e->getMessage(),
                'phone' => $this->phone,
                'attempt' => $this->attempt,
            ], 'sms');

            if ($this->attempt < $this->maxAttempts) {
                Yii::$app->queue
                    ->delay(10)
                    ->push(new self([
                        'phone' => $this->phone,
                        'message' => $this->message,
                        'attempt' => $this->attempt + 1,
                    ]));
            } else {
                Yii::error("SMS failed окончательно: {$this->phone}", 'sms');
            }
        }
    }
}