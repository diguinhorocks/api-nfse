<?php

require __DIR__ . '/../vendor/autoload.php';

use Respect\Rest\Router;

$r3 = new Router;

$r3->get('/nf/generate', array('Nf\Controller\Nf', 'getNfInfo'));
