<?php
namespace UniScraper\Utility\Config;

use CustomLibrary\PointerBag;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\Processor as ConfigProcessor;

abstract class AbstractConfig
{
	/**
	 *
	 * @var \CustomLibrary\PointerBag
	 */
	protected $bag;
	
	final public function __construct($resources) {
		$resources = array_values((array) $resources);
		
		$this->bag = new PointerBag();
		$this->load($resources);
		
		// validate config if needed
		if (method_exists($this, 'setValidatorTree')) {
			$configTree = new TreeBuilder();
			$rootNode = $this->setValidatorTree($configTree);
			$processor = new ConfigProcessor();
			$processor->process($configTree->buildTree(), array($rootNode => $this->bag->getData()));
		}
		
		// init for children
		$this->init();
	}
	
	public function __get($name) {
		return $this->bag->$name;
	}
	
	abstract protected function load(array $resources);
	
	protected function init() {
		
	}

}