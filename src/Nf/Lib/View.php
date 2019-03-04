<?php

namespace Nf\Lib;

class View 
{

	public static $data;
	public static $content;

	public static function render($file) {

		self::$content = __DIR__ . '/../View/' . $file . '.php';

		return new self;
	}

	public function with($name, $value) {

		self::$data[$name] = $value;

		return $this;

	}

	public function __toString() {

		foreach (self::$data as $key => $d) {
			$$key = $d;
		}

		include (__DIR__ . '/../View/Layout/header.php');
		include (self::$content);
		include (__DIR__ . '/../View/Layout/footer.php');

		return '';
	}

}