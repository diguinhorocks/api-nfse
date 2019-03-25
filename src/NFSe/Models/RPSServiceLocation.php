<?php

namespace NFSe\Models;


class RPSServiceLocation
{
	/**
	 * 
	 * Caracter 10 Tipo do Logradouro do local de Prestação de Serviços * Informar somente se Local de Prestação de Serviços
     * diferente do Endereço do Tomador 
     * Informar segundo a tabela que segue:
     * 1. RUA
     * 2. AVENIDA
     * 3. PRAÇA
     * 4. ALAMEDA
     * 5. Tomador Consumidor Final não pode ter local de prestação
	 * de serviços
	 *
	 * @var string
	 */
	public $tipolog;

	/**
	 * 
	 * Caracter 60 Logradouro do Local de Prestação de Serviços
	 * Regras:
	 * 1. Obrigatório Somente se o campo <TipoLogLocPre> foi
	 * informado. Poderá ser informado endereço de prestação no
	 * exterior também. Neste caso a UF deve ser igual a EX e o
	 * município = EXTERIOR. 
	 *
	 * @var float
	 */
	public $log;

	/**
	 * 
	 * Caracter 10) Número do Endereço do Local de Prestação de Serviços
     * 1. Obrigatório Somente se o campo <TipoLogLocPre> foi informado
     * $std->tomador->localprestacao->complend = ""; Caracter 60
	 *
	 * @var string
	 */
	public $numend;

	/**
	 * 
	 * caracter 60
	 *
	 * @var string
	 */
	public $complend;

	/**
	 *
	 * Caracter 60 Obrigatorio de CPF ou CNPJ for informado Informar “EXTERIOR” para operações com o exterior
	 *
	 * @var string
	 */
	public $mun;

	/**
	 * 
	 * Caracter 60 Informar “EXTERIOR” para serviços prestados no 
	 * Exterior
	 *
	 * @var string
	 */
	public $bairro;

	/**
	 * 
	 * Caracter 2 Informar “EX” para operações com o exterior
	 *
	 * @var string
	 */
	public $siglauf;

	/**
	 * 
	 * numerico 8 Se <SiglaUFLocpre> = 'EX' campo do CEP deve vir zerado
	 *
	 * @var string
	 */
	public $cep;


	public function build($data) 
	{
		if (!isset($data) || !is_array($data) || empty($data)) {
			throw new \Exception("Dados Inválidos.");
		}

		$rpsLocationData = $data;

		$this->tipolog		= $rpsLocationData['tipolog'];
		$this->log			= $rpsLocationData['log'];
		$this->numend		= $rpsLocationData['numend'];
		$this->complend		= $rpsLocationData['complend'];
		$this->bairro		= $rpsLocationData['bairro'];
		$this->mun			= $rpsLocationData['mun'];
		$this->siglauf		= $rpsLocationData['siglauf'];
		$this->cep			= $rpsLocationData['cep'];

		return $this;
	}
}