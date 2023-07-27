<?php

namespace Savvym\Chatgpt;

use GuzzleHttp\Client;
use Savvym\Chatgpt\Exceptions\HttpException;
use Savvym\Chatgpt\Exceptions\ServerException;
use Savvym\Chatgpt\Interfaces\HistoryInterface;

class ChatGPT {
    protected string $key;
    protected string $model = "gpt-3.5-turbo";
    protected array $guzzleOptions = [];
    protected array $messages = [];

    protected HistoryInterface|null $history;

    public function __construct(string $key, HistoryInterface $history = null) 
    {
        $this->key = $key;
        $this->history = $history;
    }

    public function setGuzzleOptions(array $options)
    {
        $this->guzzleOptions = $options;
    }

    public function setModel(string $model)
    {
        $this->model = $model;
    }

    public function getHttpClient()
    {
        return new Client($this->guzzleOptions);
    }

    public function chat(string $msg)
    {
        $url = "https://api.openai.com/v1/chat/completions";

        $this->messages = $this->history?->get() ?? [];

        $this->messages[] = ['role' => 'user', 'content' => $msg];

        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '.$this->key
        ];
        
        $postData = [
            "model" => $this->model,
            "messages" => $this->messages,
        ];

        try {
            $response = $this->getHttpClient()->post($url, [
                'headers' => $headers,
                'json' => $postData
            ])->getBody()->getContents();
        } catch(\Exception $e) {
            throw new HttpException($e->getMessage(), $e->getCode(), $e);
        }

        try {
            $data = json_decode($response, true);
            $message = $data['choices'][0]['message'];
        } catch(\Exception $e) {
            throw new ServerException($e->getMessage(), $e->getCode(), $e);
        }

        $this->messages[] = ['role' => $message['role'], 'content' => $message['content']];
        
        $this->history?->set($this->messages);

        return $message['content'];
    }


}