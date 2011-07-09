<?php
namespace prisoner;

class StrategyResponse
{

	const EVIL = '0';

	const GOOD = '1';

	const UNKNOWN = 'U';

	private $memory;

	private $response;

	public function __construct($memory, $response) {
		$this->memory	= rtrim($memory, self::UNKNOWN);
		$this->response	= $response;
	}

	public function getResponse() {
		return $this->response;
	}

	public function isValid() {
		return rtrim($memory, self::UNKNOWN) == $this->memory;
	}

	public function toCanonicalString($memorySize) {
		return str_pad($memory, $size, self::UNKNOWN, \STR_PAD_LEFT) . $this->response;
	}

	public function __toString() {
		return $this->memory . $this->response;
	}

}
