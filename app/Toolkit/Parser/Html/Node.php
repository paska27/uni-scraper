<?php

namespace UniScraper\Toolkit\Parser\Html;

use UniScraper\Toolkit\Parser\AbstractNode as AbstractNode;

class Node extends AbstractNode {

	private $text;
	
	private $attributes;

	public function node($path, $direction, $level) {
		// find html nodes
	}

	public function get($property = 'text') {
		if ('text' == $property) {
			return $this->text;
		} else {
			return $this->attributes[$property];
		}
	}

}
