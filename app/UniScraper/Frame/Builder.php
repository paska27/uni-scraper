<?php
namespace UniScraper\Frame;

use UniScraper\Utility\InterfaceRunable;
use UniScraper\Frame\UnisConfig;
use UniScraper\Frame\ServiceFactory\ServiceManager;

class Builder implements InterfaceRunable
{
	/**
	 * Path to actual application instance.
	 * 
	 * @var string
	 */
	private $pathApp;
	
	public function __construct($pathApp) {
		$this->pathApp = rtrim($pathApp, '/\\') . '/';
	}
	
	public function run() {
		// create unis.json config service
		$unisConfig = ServiceManager::add('unis_config', new UnisConfig(array('unis.json', PATH_APP, $this->pathApp)));
		
		// create toolkit objects as services
		foreach ($unisConfig->toolkit->v() as $tool => $type) {
			ServiceManager::produce("{$type}_{$tool}");
		}
		// create user defined services
		if ($service = $unisConfig->service->v()) {
			foreach ($service as $name => $data) {
				ServiceManager::addDefinition($name, $data->type->v(), 
					UnisConfig::processServiceArgs($data->args->v(), $this->pathApp));
			}
		}
	}

}