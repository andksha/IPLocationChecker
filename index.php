<?php 

require 'config/database.php';
require 'IPLocationChecker/IPLocationChecker.php';

$ip = new IPChecker($pdo);

$ip->checkIPLocation($pdo);