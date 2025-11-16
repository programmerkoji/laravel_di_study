<?php

class MessageService implements MessageServiceInterface
{
    public function send(string $msg)
    {
        echo "[MessageService] {$msg}\n";
    }
}
