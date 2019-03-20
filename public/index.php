<?php

require __DIR__ . '/../vendor/autoload.php';

use Respect\Rest\Router;

$r3 = new Router;

$r3->post('/nfse/validate', array('NFSe\Controller\NFSeController', 'validateNFSeInfo'));

$r3->post('/nfse/send', array('NFSe\Controller\NFSeController', 'sendNFSeInfo'));
$r3->post('/nfse/read-batch/*', array('NFSe\Controller\NFSeController', 'readBatchNFSeInfo'));
$r3->post('/nfse/read/*', array('NFSe\Controller\NFSeController', 'readNFSeInfo'));
$r3->post('/nfse/cancel/*', array('NFSe\Controller\NFSeController', 'cancelNFSe'));