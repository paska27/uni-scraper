<?php
namespace UniScraper\Frame;

use UniScraper\Frame\UnisConfig;
use UniScraper\Frame\ServiceFactory\ServiceManager;

class Builder
{
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
		$unisConfig = ServiceManager::add('unis_config', new UnisConfig(array('unis.json', PATH_APP, $this->pathApp)));
		
		// 2. load services from config (toolkit/user services)
		foreach ($unisConfig->toolkit->v() as $tool => $type) {
			ServiceManager::produce("{$type}_{$tool}");
		}
		
		// 3. run jobs
	}

}