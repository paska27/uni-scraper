<?php
namespace UniScraper\Service\ToolkitFactory;

use UniScraper\Service\AbstractFactory;
use UniScraper\Toolkit\Parser\Html\HtmlParser;

class HtmlParserFactory extends AbstractFactory
{
	const ARG_PAGE = 'page';
	
	public function build() {
		$parser = new HtmlParser();
		
		if (array_key_exists(self::ARG_PAGE, $this->args)) {
			$parser->setPage($this->args[self::ARG_PAGE]);
		}
		
		return $parser;
	}
}