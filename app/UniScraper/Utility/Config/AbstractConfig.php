<?php
namespace UniScraper\Utility\Config;

use CustomLibrary\PointerBag\ReadableBag as PointerBag;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\Processor as ConfigProcessor;

abstract class AbstractConfig
{
	/**
	 *
	 * @var PointerBag
	 */
	protected $bag;
	
	public function __construct($resources) {
		$resources = array_values((array) $resources);
		
		$this->bag = new PointerBag();
		$this->load($resources);
		
		// validate config if needed
		if (method_exists($this, 'setValidatorTree')) {
			$configTree = new TreeBuilder();
			$rootNode = $this->setValidatorTree($configTree);
			$processor = new ConfigProcessor();
			$processor->process($configTree->buildTree(), array($rootNode => $this->bag->toArray()));
		}
	}
	
	public function __get($name) {
		return $this->bag->$name;
	}
	
	abstract protected function load(array $resources);

}