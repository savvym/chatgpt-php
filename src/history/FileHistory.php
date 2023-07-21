<?php

namespace Savvym\Chatgpt\History;
use Savvym\Chatgpt\Interfaces\HistoryInterface;


class FileHistory implements HistoryInterface
{
    protected string $file_path;

    public function __construct(string $file_path)
    {
        $this->file_path = $file_path;
    }

    public function get() : array
    {
        if (file_exists($this->file_path)) {
            include $this->file_path;
            return $arr;
        }
        return [];
    }

    public function set(array $messages) : bool
    {
        $text='<?php $arr='.var_export($messages,true).';';  
        if (false !== fopen($this->file_path, 'w')) {
            file_put_contents($this->file_path, $text);
            return true;
        } else {
            return false;
        }
    }

    public function clear(): bool 
    {
        return unlink($this->file_path);
    }
}