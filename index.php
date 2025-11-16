<?php

require './Container.php';
require './Logger.php';
require './MessageServiceInterface.php';
require './MessageService.php';
require './UserNotifier.php';

$container = new Container;

// ★ インターフェイス → 実装クラス をバインドする（Laravel の bind と同じ）
$container->bind(
	MessageServiceInterface::class,
	MessageService::class
);

// ★ 依存解決（UserNotifier が interface を要求している）
$notifier = $container->make(UserNotifier::class);

$notifier->notify();

class Mailer {}
class UserService {
	public function __construct(Mailer $mailer){}
}

$userService = $container->make(UserService::class);

$container->singleton('config', fn() => ['name' => 'Mini App']);

$config1 = $container->make('config');
$config2 = $container->make('config');

var_dump($config1 === $config2);