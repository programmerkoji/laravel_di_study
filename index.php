<?php

require './Container.php';

$containter = new Container;
$containter->set('config', ['app_name' => 'Mini App']);
$config = $containter->get('config');

var_dump($config);