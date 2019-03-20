<?php

namespace NFSe\Lib;

class SoapClientCustom extends \SoapClient {

    function __construct($wsdl, $options) {
        parent::__construct($wsdl, $options);
    }
    public function __doRequest($request, $location, $action, $version) 
    { 
        $result = parent::__doRequest($request, $location, $action, $version); 
        return $result; 
    } 
    function __myDoRequest($array,$op) { 
        $request = $array;
        $location = 'http://xxxxx:xxxx/TransactionServices/TransactionServices6.asmx';
        $action = 'http://www.micros.com/pos/les/TransactionServices/'.$op;
        $version = '1';
        $result =$this->__doRequest($request, $location, $action, $version);
        return $result;
    } 
}
 
?>