<?php

namespace NFSe\Models;


class RPSTax
{
	/**
     * 
     * Caracter 10 Siglas de tributos permitidas:
        // COFINS
        // CSLL
        // INSS
        // IR
        // PIS
        // Caso tenha algum que não esteja na lista deve verificar com a prefeitura.
     *
	 * @var string
	 */
    public $sigla;

    /**
     * 
     * numerico 5,2 
     *
	 * @var float
	 */
    public $aliquota;

    /**
     * 
     * Numérico 10,2
     *
	 * @var string
	 */
    public $valor;


    public function build($data) 
    {
    	if (!isset($data) || !is_array($data) || empty($data)) {
			throw new \Exception("Dados Inválidos.");
		}

		$rpsTaxData = $data;

	    $this->sigla 	= $rpsTaxData['sigla'];
	    $this->aliquota = $rpsTaxData['aliquota'];
	    $this->valor 	= $rpsTaxData['valor'];
    }

    /*public function add ($localPrestacao) 
    {
    	$this->localPrestacao = $localPrestacao;
    }*/
}