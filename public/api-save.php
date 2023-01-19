<?php

require_once __DIR__ . '/../bootstrap.php';
$config = require __DIR__ . '/../config.php';

$address = new Address($_GET);

$mysqlStorage = new MysqlStorage($config);
$addressSaver = new AddressSaver($mysqlStorage);
$addressSaver->save($address);

$response = new JsonResponse(['success'  => true]);
$response->outputAndTerminate();
