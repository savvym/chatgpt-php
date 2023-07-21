<h1 align="center">ChatGPT PHP</h1>
<p align="center">基于ChatGPT API的PHP组件 </p>

## 安装
```bash
$ composer require savvym/chatgpt -vvv
```
## 配置
在使用本扩展前，你需要去[OpenAI](https://platform.openai.com/account/api-keys)获取应用的API key.

## 使用
无上下文功能：
```php
use Savvym\Chatgpt\ChatGPT;

$key = 'xxxxxxxxxxxxx';
$c = new ChatGPT($key);
```
带上下文功能：
```php
use Savvym\Chatgpt\ChatGPT;
use Savvym\Chatgpt\History\FileHistory;

$key = 'xxxxxxxxxxxxx';
$history = new FileHistory('./data/cache.php');
$c = new ChatGPT($key, $history);
$res = $c->chat('你好');
$res = $c->chat('做一首诗');
$res = $c->chat('翻译前面的话');
```
### 参数说明
```php
string chat(string $msg)
```
> 
- `$msg` - 发送消息

### 参考
- [OpenAI](https://platform.openai.com/)

## TODO
- [ ] Redis history
- [ ] ...
## Licence
MIT