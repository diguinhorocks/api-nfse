<?php

namespace NFSe\Models;


class RPSModel
{

	/**
	 * 
	 * Tipo de NFS 'RPS' e 'RPC'.
	 *
	 * @var string
	 */
	public $tipo = 'RPS';
	/**
	 * 
	 * 9 numericos - nao pode ser o mesmo de uma nota processada anterior pra nao dar erro 
	 *
	 * @var int
	 */
	public $numero = 12;
	/**
	 * 
	 * string 3 
	 *
	 * @var int
	 */
	public $serie = 'A';

	/**
	 * 
	 * dd/mm/yyyy
	 *
	 * @var string|date
	 */
	public $dtemi;

	/**
	 * 
	 * retenção na fonte SIM ou NAO
	 *
	 * @var string
	 */
	public $retfonte = "NAO";

	/**
	 * 
	 * codigo do serviço string até 10
	 *
	 * @var string
	 */
	public $codsrv;

	/**
	 * 
	 * Discriminação da natureza do serviço prestado \\\ indica quebra de linha
	 *
	 * @var int
	 */
	public $discrsrv = 2;

	/**
	 * 
	 * Numérico 16,2
	 *
	 * @var float(16,2)
	 */
	public $vlnfs = 2.00;

	/**
	 * 
	 * Numérico 16,2
	 *
	 * @var float(16,2)
	 */
	public $vlded = 2.00;

	/**
	 * 
	 * string 4000 Obrigatório se Valor da dedução > 0. Ele poderá também
			poderá ser utilizado caso o operador necessite informar
			retenções obrigatórias como IRPJ, PIS, COFINS, CSLL,
			INSS etc., sem necessariamente ter um valor no campo
			valor da dedução. O “\\” representa quebra de linha e assim
			será considerado na impressão da nota gerada.
			calcular no factory $std->VlBasCalc = ""; 
			Numérico 16,2 Deve ser igual ao informado no campo valor da nota menos
			o informado no campo de valor de dedução
	 *
	 * @var string
	 */
	public $discrded;

	/**
	 * 
	 * Numérico 5,2
		calcular no factory $std->vliss = 111.11; //Numérico 16,2 Obrigatório se <RetFonte> = 'NAO' Valor igual a 0 (zero) se <RetFonte> = 'SIM’
		$std->vlissret = 34.55; //Numérico 16,2 Obrigatório se <RetFonte> = 'SIM' Valor igual a 0 (zero) se <RetFonte> = 'NAO'
	 *
	 * @var float(5,2)
	 */
	public $alqiss = 2;


	/**
	 * 
	 * entidade tomador (RPSCollector)
	 *
	 * @var NFSe\Models\RPSCollector
	 */
	public $tomador = null;

	/**
	 * 
	 * conjunto de entidades tributo (RPSTax)
	 *
	 * @var NFSe\Models\RPSTax
	 */
	public $tributos = null;


	public function build($data) 
	{
		if (!isset($data) && !is_array($data)) {
			throw new Exception("Dados Inválidos.");
		}

		$rpsData = $data;

		$this->tipo 		= $rpsData['tipo'];
		$this->numero   	= $rpsData['numero'];
		$this->serie 		= $rpsData['serie'];
		$this->dtemi        = $rpsData['dtemi'];
		$this->discrsrv     = $rpsData['discrsrv'];
		$this->codsrv 		= $rpsData['codsrv'];
		$this->vlnfs     	= $rpsData['vlnfs'];
		$this->vlded      	= $rpsData['vlded'];
		$this->discrded     = $rpsData['discrded'];
		$this->alqiss       = $rpsData['alqiss'];
		$this->vliss        = $rpsData['vliss'];
		$this->vlissret	    = $rpsData['vlissret'];
	}

	public function addCollector (RPSCollector $collector) 
	{
		$this->tomador = $collector;
	}

	public function addTax (RPSTax $tax) 
	{
		$this->tributos[] = $tax;
	}

	/**
	 * add a RPSLocation to a NFSe
	 *
	 * @param Models\RPSServiceLocation $rpsServiceLocation
	 *
	 * @return void
	**/
	public function addServiceLocation(RPSServiceLocation $rpsServiceLocation) {

		if (property_exists($this->tomador, 'localprestacao')) {
			$this->tomador->localprestacao = new \stdClass;
		}

		$this->tomador->localprestacao = $rpsServiceLocation;
	}
}