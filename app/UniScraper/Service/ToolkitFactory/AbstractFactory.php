<?php
namespace UniScraper\Service\ToolkitFactory;

abstract class AbstractFactory
{
	protected $args = array();

	public static function build($serviceName, $args = array()) {
		$factory = new static($args);
		$object = $factory->produce();
		
		ServiceProvider::add($serviceName, $object);
	}
	
	public function __construct($args = array()) {
		$this->args = $args;
	}
	
	abstract public function produce();

}