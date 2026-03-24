<?php

declare(strict_types=1);

namespace app\services;

class SmsService
{
    private string $apiKey;
    private string $sender;

    public function __construct(string $apiKey, string $sender)
    {
        $this->apiKey = $apiKey;
        $this->sender = $sender;
    }

    public function send(string $phone, string $message): bool
    {
        $url = 'https://smspilot.ru/api.php';
        $params = [
            'send' => $message,
            'to' => $phone,
            'from' => $this->sender,
            'apikey' => $this->apiKey,
            'format' => 'json',
        ];
        $response = file_get_contents($url . '?' . http_build_query($params));
        if (!$response) {
            return false;
        }
        $data = json_decode($response, true);
        return isset($data['send'][0]['status']) && $data['send'][0]['status'] == '0';
    }

    public function getBalance(): ?float
    {
        $url = 'https://smspilot.ru/api.php';
        $params = [
            'balance' => 1,
            'apikey' => $this->apiKey,
            'format' => 'json',
        ];
        $response = file_get_contents($url . '?' . http_build_query($params));
        if (!$response) {
            return null;
        }
        $data = json_decode($response, true);
        return $data['balance'] ?? null;
    }
}