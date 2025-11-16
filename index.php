<?php

require './Container.php';
require './Logger.php';

$containter = new Container;

class Mailer {}
class UserService {
	public function __construct(Mailer $mailer){}
}

$userService = $containter->make(UserService::class);

$containter->singleton('config', fn() => ['name' => 'Mini App']);

$config1 = $containter->make('config');
$config2 = $containter->make('config');

var_dump($config1 === $config2);