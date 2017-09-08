<?php
declare(strict_types = 1);

$env = getenv('COMPOSER_VENDOR_DIR');
return require [$env, dirname(__DIR__) . '/vendor'][(false === $env) || ('vendor' === $env)] . '/autoload.php';
