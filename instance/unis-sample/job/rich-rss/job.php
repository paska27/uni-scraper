<?php

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

	private function extractOneItem(HtmlNode $item)
	{
		$this->extractFields('list.item.fields');
		
		
	}
	
}