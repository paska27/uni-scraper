<?php
namespace UniScraper\Service
{

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class ServiceProvider
{

	/**
	 *
	 * @var ContainerBuilder
	 */
	static private $contanier;

	static public function add($serviceName, $object) {
		$container = self::getContainer();
		$container->setDefinition($serviceName, new Definition())->setSynthetic(true);
		$container->set($serviceName, $object);
	}

	static public function get($serviceName) {
		return self::$contanier->get($serviceName);
	}

	/**
	 * 
	 * @return ContainerBuilder
	 */
	static private function getContainer() {
		if (empty(self::$contanier)) {
			self::$contanier = new ContainerBuilder();
		}
		return self::$contanier;
	}

}
}

// global code
namespace
{

use UniScraper\Service\ServiceProvider;

	function service($serviceName) {
		return ServiceProvider::get($serviceName);
	}

}