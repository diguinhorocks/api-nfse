<?php

namespace Nf\Controller;

use Nf\Models\Order;
use Nf\Lib\View;

class Nf 
{

	public function getNfInfo($id = null) {

		return json_encode(['test' => 'oi']);
	}
}