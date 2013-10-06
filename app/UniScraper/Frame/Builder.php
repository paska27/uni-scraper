<?php
namespace UniScraper\Frame;

use UniScraper\Service\Config\UnisConfig;

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
		
		// 2. load services from config (toolkit/user services)
		
		// 3. run jobs
	}

}