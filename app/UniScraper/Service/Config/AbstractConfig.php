<?php
namespace UniScraper\Service\Config;

use CustomLibrary\PointerBag;

abstract class AbstractConfig
{
	/**
	 *
	 * @var \CustomLibrary\PointerBag
	 */
	protected $bag;
	
	public function __construct() {
		$this->bag = new PointerBag();
	}
	
	public function __get($name) {
		return $this->bag->$name;
	}
	
	abstract protected function load(array $resources);

}