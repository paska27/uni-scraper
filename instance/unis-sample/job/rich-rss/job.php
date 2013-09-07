<?php

namespace UnisKeywordSearch\Job;

use UniScraper\Frame\Job\AbstractJob;

class RichRssJob extends AbstractJob {
	private $results;
	
	public function run() {
		foreach ($this->getItems() as $item) {/* @var HtmlNode $item */
			$this->extractOneItem($item);
		}
		
		$this->handleResults();
	}
	
	private function getItems() {
		$this->browse(':events_list');
		
		return $this->parse(':list') ? $this->nodes : array();
	}

	private function extractOneItem(HtmlNode $item) {
		$item = array();
		
		// list item
		$item['list'] = $this->extract(':list:fieldMap');
		
		// details
		$this->browse(':details_url');
		$this->parse();
		$item['details'] = $this->extract(':details:fieldMap');
		
		// store fields for an item
		$this->results[] = $item;
	}

	public function handleResults() {
		if (empty($this->results)) {
			return;
		}
		
		// merge retults
		$saveFields = array('title', 'description', 'venue', 'datestart', 'dateend', 'email', 'rating');
		
		$dataSet = array();
		foreach ($this->results as $item) {
			$listFields = $item['list'];
			$detailFields = $item['details'];
			
			$data = array_merge(array_intersect_key(array_merge($listFields, $detailFields), array_fill_keys($saveFields, 0/*dummy*/)));
			
			// save image on the host
			$data['image_hash'] = service('ftp')->store($detailFields['image']);
			
			$dataSet[] = $data;
		}
		
		$this->saveResultsDataSet($dataSet);
	}

	private function saveResultsDataSet($dataSet) {
		service('db')->saveDataSet('results'/*table name*/, $dataSet);
	}
	
}