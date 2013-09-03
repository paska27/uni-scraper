<?php

namespace UnisSample\Job;

use UniScraper\Frame\Job\AbstractJob;

class RichRssJob extends AbstractJob {
	public function run() {
		foreach ($this->getItems() as $item) {/* @var HtmlNode $item */
			$this->extractOneItem($item);
		}
		
		$this->handleResults();
	}
	
	private function getItems() {
		$this->browse('events_list');
		
		$this->parse('extract.list.item');
		
		return $this->nodes;
	}

	private function extractOneItem(HtmlNode $item) {
		// list item
		$this->extractFields($item, 'list.item.fields');
		
		// details
		$this->browse($this->spec('list.details_url'));
		$this->parse();
		$this->extractFields($this->nodes, 'details.fields');
	}
	
}