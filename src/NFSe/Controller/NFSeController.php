<?php

namespace NFSe\Controller;

use NFSe\Models\NFSe;

class NFSeController
{

	public function validateNFSeInfo() {

		$nfse = new NFSe;
		$data = json_decode(file_get_contents('php://input'), true);

		return $nfse->build($data)->validate();
	}

	public function sendNFSeInfo() {

		$nfse = new NFSe;
		$data = json_decode(file_get_contents('php://input'), true);

		return $nfse->build($data)->send();
	}

	public function readBatchNFSeInfo() {

		$nfse = new NFSe;
		$data = json_decode(file_get_contents('php://input'), true);

		return $nfse->setConfig($data['config'])->readBatch($data['protocolo']);
	}

	public function readNFSeInfo() {

		$nfse = new NFSe;
		$data = json_decode(file_get_contents('php://input'), true);

		return $nfse->setConfig($data['config'])->read($data['protocolo']);
	}

	public function cancelNFSe() {

		$nfse = new NFSe;
		$data = json_decode(file_get_contents('php://input'), true);

		return $nfse->setConfig($data['config'])->cancel($data['data']);
	}
}