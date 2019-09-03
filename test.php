<?php
require_once "vendor/autoload.php";

use React\EventLoop\Factory;
use Twisted\YasminWrapper\Client;

$loop = Factory::create();
$client = new Client("!", [], $loop);

$client->login("NjE4MjE2MjU3ODA3ODQzMzc0.XW2c5Q.DJIKHjbWa6GfivNGhCfkhJIx-Gk")->done();

$loop->run();