<?php 

require 'config/database.php';
require 'IPLocationChecker/IPLocationChecker.php';

$ip = new IPChecker($pdo);

var_dump($ip->checkIPLocation($pdo));die;