<?php
$config = require(__DIR__.DIRECTORY_SEPARATOR.'config/app.php');
spl_autoload_register();

(new \App\Application($config))->run();
