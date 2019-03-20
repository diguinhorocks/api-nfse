<?php

namespace NFSe\Models;

use NFSe\Lib\InternalTools as Tools;
use NFSe\Lib\Rps;
use NFePHP\NFSeTrans\Common\Soap\SoapCurl;
use NFePHP\NFSeTrans\Common\Soap\SoapFake;
use NFSe\Lib\SoapWrapper;
use NFePHP\NFSeTrans\Common\FakePretty;
use NFSe\Models\RPSModel;
use NFSe\Lib\Validatr as v;

class NFSe
{	

	/**
	 * @var string
	 */
	protected $cnpj;

	/**
	 * @var string
	 */
    protected $im;

    /**
     * 
     * ira determinar as urls e outros dados
     *
	 * @var string
	 */
    protected $cmun;

    /**
	 * @var string
	 */
    protected $razao;

    /**
     * 
     * codigo do usuário usado no login
     *
	 * @var string
	 */
    protected $usuario;

    /**
     * 
     * codigo do contribunte usado no login
     *
	 * @var string
	 */
    protected $contribuinte = ''; //codigo do contribunte usado no login

    /**
	 * @var int
	 */
    protected $tipotrib = 4;

    /**
	 * @var string|date(dd/mm/YYYY)
	 */
    protected $dtadesn = '';

    /**
	 * @var int
	 */
    protected $alqisssn = 0;

    /**
     * 
     * 1-producao, 2-homologacao
     *
	 * @var int
	 */
    protected $tpamb = 2;

    /**
	 * @var int
	 */
    protected $webservice = 2;

    /**
	 * @var array NFePHP\NFSeTrans\Rps
	 */

    protected $rpsList = [];

	public function __construct() 
	{
	}

	public function setConfig($config)
	{

		if (!isset($config) || !is_array($config)) {
			throw new \Exception("Configurações Inválidas.");
		}

	    $this->cnpj 		= $config['cnpj'];
	    $this->im   		= $config['im'];
	    $this->cmun 		= $config['cmun'];
	    $this->razao        = $config['razao'];
	    $this->usuario      = $config['usuario']; 
	    $this->contribuinte = $config['contribuinte']; 
	    $this->tipotrib     = $config['tipotrib'];
	    $this->dtadesn      = $config['dtadesn'];
	    $this->alqisssn    	= $config['alqisssn'];
	    $this->tpamb        = $config['tpamb'];
	    $this->webservice   = $config['webservice'];

	    return $this;
	}

	/**
	 * build service config
	 *
	 * @param array $data - raw request data
	 *
	 * @return string|json
	**/
	public function getConfig() 
	{

		return [
			'cnpj' 		   => $this->cnpj,
			'im'   		   => $this->im,
		    'cmun' 		   => $this->cmun, 
		    'razao'        => $this->razao,
		    'usuario'      => $this->usuario, 
		    'contribuinte' => $this->contribuinte, 
		    'tipotrib'     => $this->tipotrib,
		    'dtadesn'      => $this->dtadesn,
		    'alqisssn'     => $this->alqisssn,
		    'tpamb'        => $this->tpamb, 
		    'webservice'   => $this->webservice
		];
	}

	/**
	 * build entire RPS content for sending 
	 *
	 * @param array $data - raw request data
	 *
	 * @return string|json
	**/
	public function build(array $data) 
	{
		if (!is_array($data)) {
			throw new \Exception("é necessário os dados ser um array!");
		}

		try {

			//setting config
			$this->setConfig($data['config']);

			//setting RPS
			$rps = new RPSModel;
			$rps->build($data['nfse']);

			// setting tomador
			$rpsCollector = new RPSCollector;
			$rpsCollector->build($data['nfse']['tomador']);

			//adding tomador
			$rps->addCollector($rpsCollector);

			//setting tributos
			$taxes = [];

			if (isset($data['nfse']['tributos']) && count($data['nfse']['tributos'])) {

				foreach ($data['nfse']['tributos'] as $tributo) {

					$rpsTax = new RPSTax;
					$rpsTax->build($tributo);
					//adding tributo
					$rps->addTax($rpsTax);
				}
			}
	
			//adding RPS to NF
			$this->addRps(new Rps((object) (array) $rps));

			return $this;
		} catch (\Exception $e) {
			return json_encode(['err' => 1, 'msg' => $e->getMessage()]);
		}
	}

	/**
	 * cancel a NFSe
	 *
	 * @param array $data - request data
	 *
	 * @return string|json
	**/
	public function cancel($data) 
	{

	    $config = $this->getConfig();

		$tools = new Tools(json_encode($config));
    	$tools->loadSoapClass(new SoapWrapper());

    	try {

    		$cancelarGuia = $data['cancelarGuia'];
		    $valor = $data['valor'];
		    $motivo = $data['motivo'];
		    $numeronfse = $data['numeronfse'];
		    $serienfse = $data['serienfse'];
		    $serierps = $data['serierps'];
		    $numerorps = $data['numerorps'];

		    $response = $tools->cancelarNfse(
		        $cancelarGuia, $valor, $motivo, $numeronfse, $serienfse, $serierps, $numerorps
		    );

    	} catch (\Exception $e) {
    		return json_encode(['err' => 1, 'msg' => $e->getMessage()]);
    	}

    	header('Content-Type: application/json');
    	return json_encode($response);

	}

	/**
	 * validate and creates a RPS/NFSe
	 *
	 * 
	 *
	 * @return string|json
	**/
	public function send()
	{	

		$config = $this->getConfig();

		$tools = new Tools(json_encode($config));
    	$tools->loadSoapClass(new SoapWrapper());

    	try {

    		v::validate($this->rpsList[0]->std);

			$response = $tools->enviarLoteRps($this->rpsList);

    	} catch (\Exception $e) {
    		return json_encode(['err' => 1, 'msg' => $e->getMessage()]);
    	}

    	header('Content-Type: application/json');
    	return json_encode($response);
	}

	/**
	 * get a NFSe by number 
	 *
	 * @param string $number
	 *
	 * @return string|json
	**/
	public function read($number)
	{

		$config = $this->getConfig();

		$tools = new Tools(json_encode($config));
    	$tools->loadSoapClass(new SoapWrapper());

    	try {

			$response = $tools->consultarNfse($number);

    	} catch (\Exception $e) {
    		return json_encode(['err' => 1, 'msg' => $e->getMessage()]);
    	}

    	header('Content-Type: application/json');
    	return json_encode($response);
	}

	/**
	 * get a batch of NFSe by number 
	 *
	 * @param string $number
	 *
	 * @return string|json
	**/
	public function readBatch($number)
	{

		$config = $this->getConfig();

		$tools = new Tools(json_encode($config));
    	$tools->loadSoapClass(new SoapWrapper());

    	try {

			$response = $tools->consultarLoteRps($number);

    	} catch (\Exception $e) {
    		return json_encode(['err' => 1, 'msg' => $e->getMessage()]);
    	}

    	header('Content-Type: application/json');
    	return json_encode($response);
	}

	/**
	 * validate RPS content before its actions
	 *
	 *
	 * @return string|json
	**/
	public function validate()
	{

		$config = $this->getConfig();

		$tools = new Tools(json_encode($config));
    	$tools->loadSoapClass(new SoapWrapper());

    	try {

    		v::validate($this->rpsList[0]->std);

			$response = $tools->validarLoteRps($this->rpsList);


    	} catch (\Exception $e) {
    		return json_encode(['err' => 1, 'msg' => $e->getMessage()]);
    	}

    	header('Content-Type: application/json');
    	return json_encode($response);
	}

	//PRIVATE
	/**
	 * add a RPS to a list
	 *
	 * @param NFePHP\NFSeTrans\Rps $rps
	 *
	 * @return string|json
	**/
	private function addRps(Rps $rps) {
		$this->rpsList[] = $rps;
	}
}