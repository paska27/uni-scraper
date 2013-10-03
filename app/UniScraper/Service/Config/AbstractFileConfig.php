<?php
namespace UniScraper\Service\Config;

use Symfony\Component\Config\FileLocator;

abstract class AbstractFileConfig extends AbstractConfig
{
	protected $fileDataSet;

	public function __construct(array $resources, $filename = null) {
		parent::__construct();
		
		$this->load(empty($filename) ? $resources : $resources + array('filename' => $filename));
	}
	
	protected function load(array $resources) {
		if (!empty($resources['filename'])) {
			$filename = $resources['filename'];
			unset($resources['filename']);
		} else {
			// get first resource's filename
			$first = array_shift($resources);
			$filename = pathinfo($first, PATHINFO_BASENAME);
			array_unshift($resources, pathinfo($first, PATHINFO_DIRNAME));
		}
		
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