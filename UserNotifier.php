<?php

class UserNotifier
{
    protected MessageServiceInterface $service;

    public function __construct(MessageServiceInterface $service)
    {
        $this->service = $service;
    }

    public function notify()
    {
        $this->service->send("Hello User!");
    }
}
