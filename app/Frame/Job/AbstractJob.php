<?php

namespace UniScraper\Frame\Job;

use UniScraper\Toolkit\Parser\AbstractNode;

abstract class AbstractJob {
	
	protected $page;
	
	protected $nodes;
	
	protected $records;
	
	protected $spec;

	/**
	 *********Conrnerstone of the job*********
	 */
	
	/**
	 * Wrapper over Browser
	 * 
	 * @param string $url
	 * @return string $page
	 */
	protected function browse($url) {}
	
	/**
	 * Wrapper over Parser
	 * 
	 * @param string $path
	 * @return AbstractNode[] $nodes
	 */
	protected function parse($path = null) {}
	
	
	/**
	 * Wrapper over Exractor
	 * 
	 * @param AbstractNode[] $nodes
	 * @param string|array $spec - specification on how/what to extract from node
	 * @param string $fieldName - field name to store value as
	 */
	protected function extract($nodes, $spec, $fieldName = null) {}
	
	protected function spec($path) {}


/**
	 *********Wrapper API*********
	 */
	
	/**
	 * 
	 * @param AbstractNode $node
	 * @param string|array $fields
	 */
	protected function extractFields(AbstractNode $node, $fields) {
		if (is_string($fields)) {
			// spec path given, find fields map
			$fields = $this->spec($fields);
		}
		
		foreach ($fields as $fieldName => $spec) {
			$this->extract($node, $spec, $fieldName);
		}
	}
}
