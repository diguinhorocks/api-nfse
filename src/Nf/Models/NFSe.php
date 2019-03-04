<?php

namespace SampleApp\Models;

use SampleApp\Lib\Request;

class Order extends Request
{
	public function __construct() {
		parent::__construct();
		$this->setContentType('application/json');
	}

	public function get() {

		$this->setUrl('http://api.extra/extra/orders/status/new');
		$this->setVerb('get');
		$this->execute();

		return json_decode($this->getResponseBody());
	}

	public function getApprovedOrders() {

		$this->setUrl('http://api.extra/extra/orders/status/approved');
		$this->setVerb('get');
		$this->execute();

		return json_decode($this->getResponseBody());
	}

	public function insert($data) {

		$itemList = array();
		$customer = array(
			"name" => "Joselito",
			"lastName" => "Mendes",
			"birthDt" => "2013-10-31T11:53:31.439-02:00",
			"gender" => "Masculino",
			"documentNumber" => "123456",
			"email" => "cliente.marketplace@novo.com",
			"phoneMobile" => "83342933",
			"phoneHome" => "83342933",
			"phoneOffice" => "83342933",
			"address" => "Avenida Paulista",
			"addressNr" => "1897",
			"additionalInfo" => "Ap 101",
			"quarter" => "Centro",
			"city" => "São Paulo",
			"state" => "SP",
			"postalCd" => "12345000"
		);

		foreach ($data['data'] as $k => $d) {
			$itemList[$k]['skuName'] = $d['skuOrigin'];
			$itemList[$k]['skuId'] = $d['skuId'];
			$itemList[$k]['salePrice'] = $d['salePrice'];
			$itemList[$k]['quantity'] = 2;
		}

		$data = array('data' => array('skuidList' => $itemList, 'customer' => $customer));

		$this->setUrl('http://api.extra/orders');
		$this->setVerb('post');
		$this->setRequestBody($data);
		$this->execute();

		return json_decode($this->getResponseBody());
	}
}