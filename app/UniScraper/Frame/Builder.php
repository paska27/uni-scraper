<?php
namespace UniScraper\Frame;

use UniScraper\Service\ServiceProvider;
use UniScraper\Service\UnisConfig;

class Builder
{
	const TOOOLKIT_FACTORY_NAMESPACE = '\\UniScraper\\Service\\ToolkitFactory\\';
	
	/**
	 * Path to actual application instance.
	 * 
	 * @var string
	 */
	private $pathApp;
	
	public function __construct($pathApp) {
		$this->pathApp = $pathApp;
	}
	
	public function run() {
		// 1. create unis.json config service
		$unisConfig = ServiceProvider::add('unis_config', new UnisConfig(array('unis.json', PATH_APP, $this->pathApp)));
		
		// 2. load services from config (toolkit/user services)
		foreach ($unisConfig->toolkit->v() as $tool => $type) {
			$factory = self::TOOOLKIT_FACTORY_NAMESPACE . ucfirst($type) . ucfirst($tool) . 'Factory';
			if (!class_exists($factory)) {
				throw new \Exception("No toolkit service factory class '$factory' found !");
			}
			
			$factory::produce("{$type}_{$tool}");
		}
		
		// 3. run jobs
	}

}