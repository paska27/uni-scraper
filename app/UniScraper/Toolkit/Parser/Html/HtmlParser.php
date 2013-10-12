<?php
namespace UniScraper\Toolkit\Parser\Html;

use UniScraper\Toolkit\Parser\AbstractParser;
use UniScraper\Toolkit\Parser\Html\HtmlNodeTree;

class HtmlParser extends AbstractParser
{
	
	/**
	 * @return HtmlNodeTree
	 */
	public function parse($page = '') {
		$page = !empty($page) ? $page : $this->page;
		$nodeTree = new HtmlNodeTree($page);
		return $nodeTree;
	}
}
