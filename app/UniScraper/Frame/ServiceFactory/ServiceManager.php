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
	
	/**
	 * Create service using Symfony's Definition.
	 * 
	 * @param string $serviceName
	 * @param string $type - object class
	 * @param array $args - construct arguments
	 */
	static public function addDefinition($serviceName, $type, array $args) {
		try {
			$definition = new Definition($type, $args);
			self::getContainer()->setDefinition($serviceName, $definition);
		} catch(\Exception $e) {
			throw new \Exception("Could not add service using definition:\n" . $e->getMessage());
		}
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
	
	static public function get($serviceName) {
		try{
			return self::$contanier->get($serviceName);
		} catch(\Exception $e) {
			throw new \Exception("No service '$serviceName' exists.");
		}
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