<?php

namespace UnisKeywordSearch;

use UniScraper\Frame\Job\AbstractJob;

class TimeoutComJob extends AbstractJob {
	private $results;

	public function run() {
		foreach ($this->getItems() as $item) {
			$this->extractOneItem($item);
		}
		
		$this->exportResults();
	}
	
	private function getItems() {
		$this->browse(':base_url');

		return $this->parse(':store') ? $this->nodes : array();
	}

	private function extractOneItem(HtmlNode $item) {
		$item = array();

		// list item
		$item['list'] = $this->extract(':fields:item');

		// details
		$this->browse(':_details_url');
		$this->parse();
		$item['details'] = $this->extract(':fields:details');

		// store fields for an item
		$this->results[] = $item;
	}

	public function exportResults() {
		$excelData = service('export')->create($this->results);
		
		service('storage')->writeJobExport($excelData, __DIR__);
	}
}