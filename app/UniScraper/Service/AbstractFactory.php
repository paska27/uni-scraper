<?php
namespace UniScraper\Service;

use UniScraper\Service\ServiceProvider;

abstract class AbstractFactory
{
	protected $args = array();

	public static function produce($serviceName, $args = array()) {
		$factory = new static($args);
		$object = $factory->build();
		
		ServiceProvider::add($serviceName, $object);
	}
	
	public function __construct($args = array()) {
		$this->args = $args;
	}
	
	abstract public function build();

}