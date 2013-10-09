<?php
namespace UniScraper\Frame\ServiceFactory
{
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use UniScraper\Utility\FileLocator;

class ServiceManager
{
	/**
	 *
	 * @var ContainerBuilder
	 */
	static private $contanier;
	
	/**
	 * 
	 * @return ContainerBuilder
	 */
	static public function getContainer() {
		if (empty(self::$contanier)) {
			self::$contanier = new ContainerBuilder();
		}
		return self::$contanier;
	}
	
	static public function add($serviceName, $object) {
		$container = self::getContainer();
		$container->setDefinition($serviceName, new Definition())->setSynthetic(true);
		$container->set($serviceName, $object);

		return $object;
	}

	static public function get($serviceName) {
		return self::$contanier->get($serviceName);
	}
	
	/**
	 * Create service using factory.
	 * 
	 * @param string $serviceName
	 * @param string $type
	 */
	static public function produce($serviceName) {
		$locator = new FileLocator(__DIR__ . '*');
		
		try {
			$factoryName = self::denormalizeServiceName($serviceName) . 'Factory';
			$factory = $locator->locate("$factoryName.php");
			$factory = strstr(str_replace('/', '\\', dirname($factory).'\\'.basename($factory, '.php')), __NAMESPACE__);
		} catch(\Exception $e) {
			throw new \Exception("Service factory '$factoryName' does not exist.\n{$e->getMessage()}");
		}
		
		return self::add($serviceName, call_user_func(array($factory, 'produce')));
	}
	
	/**
	 * E.g.: http_browser -> HttpBrowser
	 * 
	 * @param string $name - service name
	 * @return string $type - object class
	 */
	static public function denormalizeServiceName($name) {
		return ucfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $name))));
	}
}
}

// global code

namespace
{
use UniScraper\Frame\ServiceFactory\ServiceManager;

	function service($serviceName) {
		return ServiceManager::get($serviceName);
	}

}