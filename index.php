<?php

require './Container.php';
require './Logger.php';

$containter = new Container;
$containter->bind('logger', function($c) {
	return new Logger('tmp/log.txt');
});
$logger = $containter->make('logger');

var_dump($logger);