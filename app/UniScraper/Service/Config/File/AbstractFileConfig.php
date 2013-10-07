<?php
namespace UniScraper\Service\Config\File;

use UniScraper\Service\Config\AbstractConfig;
use Symfony\Component\Config\FileLocator;

abstract class AbstractFileConfig extends AbstractConfig
{
	protected function load(array $resources) {
		$filename = pathinfo($resources[0], PATHINFO_BASENAME);
		$resources = \CustomLibrary\XArray::from($resources)
			->filter(function($v){return strpos($v, '/')!==false || strpos($v, '\\')!==false;})
			->mapk(function($v, $k, $d){return str_replace($d, '', $v);}, $filename)
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