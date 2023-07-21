<?php

namespace Savvym\Chatgpt\Interfaces;

interface HistoryInterface
{
    public function set(array $messages): bool;
    public function get(): array;
    public function clear(): bool;
}