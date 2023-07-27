<?php

namespace Savvym\Chatgpt\Tests;

use PHPUnit\Framework\TestCase;
use Savvym\Chatgpt\Exceptions\HttpException;
use Savvym\Chatgpt\History\FileHistory;
use Savvym\Chatgpt\ChatGPT;

class ChatGPTTest extends TestCase
{
    public function testChatGPT()
    {
        $c = new ChatGPT('sk-xxxxxxx');
        $this->expectException(HttpException::class);
        $res = $c->chat('hello');
        var_dump($res);
    }

    public function testClearHistory()
    {
        // $this->markTestSkipped();
        $history = new FileHistory('./data/cache.php');
        $res = $history->clear();
        $this->assertSame(false, $res);
    }
}