<?php

namespace NFSe\Models;


class RPSCollector
{
	/**
	 * 
	 * caracter 11 ou 14 | CONSUMIDOR | EXTERIOR
	 *
	 * @var string
	 */
	public $cpfcnpj;
	/**
	 * 
	 * Caracter 60 Obrigatorio se CPF ou CNPJ for informado
	 *
	 * @var string
	 */
	public $razsoc;
	/**
	 * 
	 * 1. RUA 2. AVENIDA 3. PRAÇA 4. ALAMEDA
	 *
	 * @var string
	 */
	public $tipolog;

	/**
	 * 
	 * Caracter 60 Obrigatorio se CPF ou CNPJ for informado
	 *
	 * @var string
	 */
	public $log;

	/**
	 * 
	 * Caracter 10 Obrigatorio de CPF ou CNPJ for informado 
	 *
	 * @var string
	 */
	public $numend;

	/**
	 * 
	 * Caracter 60 Obrigatorio de CPF ou CNPJ for informado 
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
	 * Caracter 2 Obrigatorio de CPF ou CNPJ for informado  Informar “EX” para operações com o exterior
	 *
	 * @var string
	 */
	public $bairro;

	/**
	 * 
	 * Caracter 2 Obrigatorio de CPF ou CNPJ for informado  Informar “EX” para operações com o exterior
	 *
	 * @var string
	 */
	public $siglauf;

	/**
	 * 
	 * Obrigatorio de CPF ou CNPJ for informado 
	 *
	 * @var string
	 */
	public $cep;

	/**
	 * 
	 * numerico 10 Telefone do Tomador
	 *
	 * @var string
	 */
	public $telefone;

	/**
	 * 
	 * Caracter 20 Não Informar quando Tomador é Consumidor Final ou Pessoa do Exterior.
	 *
	 * @var string
	 */
	public $inscricaomunicipal;

	/**
	 * 
	 * Caracter 120 Quando o Tomador é pessoa Externa ou consumidor final, o campo poderá ser usado como um endereço de E-mail para envio da NFE
	 *
	 * @var string|email
	 */
	public $email1;


	/**
	 * 
	 * Deve ser diferente do campo <Email1> e só deve ser informado se a nota deve ser enviada para mais de um endereço de email
	 *
	 * @var string|email
	 */
	public $email2 = null;

	/**
	 * 
	 * Deve ser diferente dos campos <Email1> e <Email2>e só deve ser informado se a nota deve ser enviada para mais de um endereço de email
	 *
	 * @var string|email
	 */
	public $email3 = null;


	public function build($data) 
	{
		if (!isset($data) || !is_array($data) || empty($data)) {
			throw new Exception("Dados Inválidos.");
		}

		$rpsCollectorData = $data;

		$this->cpfcnpj				= $rpsCollectorData['cpfcnpj'];
		$this->razsoc				= $rpsCollectorData['razsoc'];
		$this->tipolog				= $rpsCollectorData['tipolog'];
		$this->log					= $rpsCollectorData['log'];
		$this->numend				= $rpsCollectorData['numend'];
		$this->complend				= $rpsCollectorData['complend'];
		$this->bairro				= $rpsCollectorData['bairro'];
		$this->mun					= $rpsCollectorData['mun'];
		$this->siglauf				= $rpsCollectorData['siglauf'];
		$this->cep					= $rpsCollectorData['cep'];
		$this->telefone 			= $rpsCollectorData['telefone'];
		$this->email1				= $rpsCollectorData['email1'];

		if (isset($rpsCollectorData['inscricaomunicipal']) && !empty($rpsCollectorData['inscricaomunicipal'])) {
		   $this->inscricaomunicipal   = $rpsCollectorData['inscricaomunicipal'];
		}

		if (isset($rpsCollectorData['email2']) && !empty($rpsCollectorData['email2'])) {
		   $this->email2            = $rpsCollectorData['email2'];
		}

		if (isset($rpsCollectorData['email3']) && !empty($rpsCollectorData['email3'])) {
			$this->email3               = $rpsCollectorData['email3'];
		}
	}

	/*public function add ($localPrestacao) 
	{
		$this->localPrestacao = $localPrestacao;
	}*/
}