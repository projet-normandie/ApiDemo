<?php

use Symfony\Component\HttpFoundation\Request;

$loader = require_once __DIR__ . '/../app/bootstrap.php.cache';

require_once __DIR__ . '/../app/autoload.php';
require_once __DIR__ . '/../app/AppKernel.php';
require_once __DIR__ . '/../app/AppCache.php';

$kernel = new AppKernel(
    $_SERVER['SYMFONY__PROJECT__ENV'],
    ($_SERVER['SYMFONY__PROJECT__DEBUG'] === 'true')
);
$kernel->loadClassCache();
$kernel = new AppCache($kernel);

if ($_SERVER['SYMFONY__PROJECT__DEBUG'] === 'false') {
    // When using the HttpCache, you need to call the method in your front controller instead of relying
    // on the configuration parameter
    Request::enableHttpMethodParameterOverride();
}

$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
