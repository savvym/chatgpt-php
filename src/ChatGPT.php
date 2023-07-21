<?php

namespace Savvym\Chatgpt;

use GuzzleHttp\Client;
use Savvym\Chatgpt\Interfaces\HistoryInterface;

class ChatGPT {
    protected string $API_KEY;
    protected string $model = "gpt-3.5-turbo";
    protected $guzzleOptions = [];
    protected $messages = [];

    protected HistoryInterface $history;

    public function __construct(string $API_KEY, HistoryInterface $history = null) 
    {
        $this->API_KEY = $API_KEY;
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

    public function getHttpCient()
    {
        return new Client($this->guzzleOptions);
    }

    public function chat(string $msg)
    {
        $url = "https://api.openai.com/v1/chat/completions";

        if ($this->history !== null) {
            $this->messages = $this->history->get();
        }
        $this->messages[] = ['role' => 'user', 'content' => $msg];
        
        $postData = [
            "model" => $this->model,
            "messages" => $this->messages,
        ];

        $response = $this->getHttpCient()->post($url, [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer '.$this->API_KEY
            ],
            'json' => $postData
        ])->getBody()->getContents();
        $data = json_decode($response, true)['choices'][0]['message'];
        $this->messages[] = ['role' => 'assistant', 'content' => $data['content']];
        if ($this->history !== null) {
            $this->history->set($this->messages);
        }
        return $data['content'];
    }


}