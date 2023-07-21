<?php

namespace Savvym\Chatgpt\Tests;

use PHPUnit\Framework\TestCase;
use Savvym\Chatgpt\History\FileHistory;
use Savvym\Chatgpt\ChatGPT;

class ChatGPTTest extends TestCase
{
    public function testChatGPT()
    {
        $history = new FileHistory('./data/cache.php');
        $c = new ChatGPT('sk-xxxxxxx', $history);
        $res = $c->chat('你好');
        var_dump($res);
    }

    public function testClearHistory()
    {
        $this->markTestSkipped();
        $history = new FileHistory('./data/cache.php');
        $res = $history->clear();
        $this->assertSame(true, $res);
    }
}