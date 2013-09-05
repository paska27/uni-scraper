<?php

namespace UniScraper\Frame\Job;

use UniScraper\Toolkit\Parser\AbstractNode;

abstract class AbstractJob {

	protected $page;

	protected $nodes;

	protected $records;

	protected $spec;

	abstract public function run();
	
	/**
	 * Wrapper over Browser
	 * 
	 * @param string $urlKey - url or spec key to get the url
	 * 
	 * @return string $page
	 */
	protected function browse($urlKey) {
		$url = $this->geSpecValue('browse', $urlKey);
		return $this->page = service('browser')->browse($url);
	}

	/**
	 * Wrapper over Parser
	 * 
	 * @param string $pathKey - path to page's specific area or spec key
	 * 
	 * @return AbstractNode[] $nodes
	 */
	protected function parse($pathKey = null) {
		$path = ($pathKey) ? $this->geSpecValue('parse', $pathKey) : null;
		return $this->nodes = service('parser')->parse($this->page, $path);
	}

	/**
	 * Wrapper over Exractor
	 * 
	 * @param string $fieldMapKey - {field => search} map or spec key
	 */
	protected function extract($fieldMapKey) {
		$fieldMap = $this->geSpecValue('extract', $fieldMapKey);
		return $this->records = service('extractor')->extract($this->nodes, $fieldMap);
	}


	private function geSpecValue($toolName, $key) {
		if (strpos($key, ':') !== 0) {
			return $key;
		}
		$key = $toolName . '.' . substr($key, 1);
		return service('spec')->get($key);
	}
}
