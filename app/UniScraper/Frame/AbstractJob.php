<?php
namespace UniScraper\Frame;

use UniScraper\Utility\InterfaceRunable;
use UniScraper\Toolkit\Parser\Html\HtmlNodeTree;

abstract class AbstractJob implements InterfaceRunable
{
	public function spec($path) {
		$path = explode('.', $path);
		$value = null;
		foreach ($path as $p) {
			$value = service('spec')->$p;
		}
		
		return $value->v();
	}
	
	public function browse($urlSpec) {
		$browser = $this->findTool('browser');
		$url = parse_url($urlSpec, PHP_URL_SCHEME) ? $urlSpec : $this->spec($urlSpec);
		return $browser->browse($url);
	}

	public function parse() {
		$parser = $this->findTool('parser');
		return $parser->parse($this->findTool('browser')->getPage());
	}

	private function findTool($name) {
		return service(service('unis_config')->toolkit->$name->v() . '_' . $name);
	}

}