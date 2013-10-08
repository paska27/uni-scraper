<?php
namespace UniScraper\Frame\ServiceFactory;

abstract class AbstractFactory
{
	protected $args;

	public static function produce(array $args = array()) {
		$factory = new static($args);
		return $factory->build();
	}
	
	public function __construct($args) {
		$this->args = $args;
	}
	
	abstract public function build();

}