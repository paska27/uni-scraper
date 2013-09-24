<?php
namespace UniScraper\Service\Config;

use Symfony\Component\Config\Loader\Loader;

abstract class AbstractConfig {

	/**
	 *
	 * @var \stdClass
	 */
	protected $bag;
	
	public function __get($name) {
		return $this->bag->$name;
	}
}