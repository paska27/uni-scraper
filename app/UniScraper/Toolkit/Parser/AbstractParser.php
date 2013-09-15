<?php
namespace UniScraper\Toolkit\Parser;

abstract class AbstractParser {
	/**
	 *
	 * @var string
	 */
	protected $page = '';
	
	public function setPage($page) {
		$this->page = $page;
	}
	
	public function __construct($page = '') {
		$this->page = $page;
	}
	
	abstract public function parse();
}