<?php

namespace NFSe\Lib;

use NFePHP\NFSeTrans\Common\Soap\SoapBase;
use NFePHP\NFSeTrans\Common\Soap\SoapInterface;
use NFePHP\Common\Exception\SoapException;
use NFePHP\Common\Certificate;
use Psr\Log\LoggerInterface;

class SoapWrapper extends SoapBase implements SoapInterface
{
	public function loadCertificate(Certificate $certificate) {}
	public function loadLogger(LoggerInterface $logger) {}

	public function timeout($timesecs) {}
    public function protocol($protocol = self::SSL_DEFAULT) {}

    public function proxy($ip, $port, $user, $password) {}

    protected $rootNamespaces = [
    	'VERFICARPS' => 'Sdt_processarpsin',
    	'PROCESSARPS' => 'Sdt_processarpsin',
    	'CONSULTANOTASPROTOCOLO' => 'Sdt_consultanotasprotocoloin',
    	'CONSULTAPROTOCOLO' => 'Sdt_consultaprotocoloin',
    	'CANCELANOTAELETRONICA' => 'Sdt_cancelanfe'
    ];

    /**
     * Send soap message
     * @param string $operation
     * @param string $url
     * @param string $action
     * @param string $envelope
     * @param array $parameters
     */
    public function send(
        $operation,
        $url,
        $action,
        $envelope,
        $parameters
    ) {
    	$soapClient = new \SoapClient($url . '?WSDL', array(
			'encoding' => 'UTF-8', 
			'verifypeer' => false, 
			'verifyhost' => false, 
			'soap_version'=> SOAP_1_1,
			'trace' => 1
		));

    	$response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $envelope);
    	$response = preg_replace("/(nfe:)/", "ns1:", $envelope);

    	$ns = $this->rootNamespaces[$operation];

    	$body = array($ns => new \SoapVar($response, \XSD_ANYXML));

	    $response = $soapClient->{$operation}($body);

        if ($operation == 'PROCESSARPS') {
            //save xml
            $path = realpath(__DIR__ . '/../storage/xml');

            $date = date('Y-m-d H:i:s');

            $xml = $soapClient->__getLastRequest();

            file_put_contents($path . "/enviar-(". $date .").xml", $xml);
        }

	    return $response;
    }
}