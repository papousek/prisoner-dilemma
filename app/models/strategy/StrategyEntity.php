<?php
namespace prisoner;

/**
 * @property int $memorySize
 * @property string $encoded
 */
class StrategyEntity extends \eskymo\model\Entity
{

	private $responses;

	public function getResponse($memory) {
		if (empty($this->responses)) {
			throw new \InvalidArgumentException("The strategy is not set, se it can't provide any response.");
		}
		foreach($this->responses AS $response) {
			if ($response->isValid($memory)) {
				return $response->getResponse();
			}
		}
		throw new \InvalidArgumentException("The response with memory [$memory] is not available.");
	}

	public function __set($name, $value) {
		if ($name == 'encoded') {
			$this->prepareResponses($value);
		}
		parent::__set($name, $value);
	}

	private function prepareResponses($encoded) {
		$position = 0;
		$memorySize = 0;
		$responses = array();
		while($position < strlen($encoded)) {
			for($i = 0; $i<pow(2, $memorySize); $i++) {
				$memory = substr($encoded, $position, $memorySize);
				$response = substr($encoded, $position + $memorySize, 1);
				$position += $memorySize + 1;
				if ($memory === false || $response === false || $position > strlen($encoded)) {
					throw new \InvalidArgumentException("The string [$encoded] can't be translated to strategy.");
				}
				$responses[] = new StrategyResponse($memory, $response);
				
			}
			$memorySize++;
		}
		$this->responses = $responses;
	}

}

