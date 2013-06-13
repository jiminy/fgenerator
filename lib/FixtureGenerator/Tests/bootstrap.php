<?php

use \FixtureGenerator\App;

defined('TEST_PATH') or define('TEST_PATH', __DIR__);
include_once(__DIR__ . '/../App.php');
App::createApp();
App::instance()->setBasePath(TEST_PATH);
App::instance()->setSourcePath('data');