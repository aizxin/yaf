<?php

/**
 * @name 框架入口
 * @author Sow
 */
define('APP_PATH', dirname(__DIR__));


$application = new Yaf\Application( APP_PATH . "/conf/application.ini");

$application->bootstrap()->run();

?>
