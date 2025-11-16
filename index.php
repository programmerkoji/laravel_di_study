<?php

require './Container.php';
require './Logger.php';

$containter = new Container;

class Mailer {}
class UserService {
	public function __construct(Mailer $mailer){}
}

$userService = $containter->make(UserService::class);
var_dump($userService);