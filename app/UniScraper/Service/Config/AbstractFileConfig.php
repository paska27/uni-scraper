<?php
namespace UniScraper\Service\Config;

use Symfony\Component\Config\FileLocator;

abstract class AbstractFileConfig extends AbstractConfig
{
	protected function load(array $resources) {
		$filename = pathinfo($resources[0], PATHINFO_BASENAME);
		$resources = \CustomLibrary\XArray::from($resources)
			->filter(function($v){return strpos($v, '/')!==false || strpos($v, '\\')!==false;})
			->map(function($v){return pathinfo($v, PATHINFO_DIRNAME);})
			->toArray();
		
		$locator = new FileLocator($resources);
		foreach  ($locator->locate($filename, null /*currentPath*/, false/*first*/) as $file) {
			try {
				$this->bag->mergeData($this->parseData(file_get_contents($file)));
			} catch (\Exception $e) {
				throw new \Exception($e->getMessage() . ", file: '$file'");
			}
		}
	}
	
	abstract protected function parseData($data);
}