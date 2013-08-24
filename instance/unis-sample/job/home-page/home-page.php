<?php

class HomePageJob extends AbstractJob {
	public function run () {
		$this->browse($this->spec('base_url'));
		if (!$this->page) {
			$this->hookTrigger('page-not-found', $this->spec('base_url'));
		}

		$this->parse();

		$this->extract($this->spec('path_about'));

		if (!$this->results) {
			$this->hookTrigger('about-section-absent');
		}
		
		$this->storeResults();
	}
}