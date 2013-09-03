<?php

namespace UniScraper\Toolkit\Parser;

abstract class AbstractNode {
	const DIRECTION_DOWN = 'direction_down';
	const DIRECTION_UP = 'direction_up';
	
	abstract public function node($path, $direction, $level);
	
	abstract public function get($property);
	
	final public function descendants($path, $level = null) {
		return $this->node($path, self::DIRECTION_DOWN, $level);
	}
	
	final public function children($path) {
		return $this->descendants($path, 1);
	}
	
	final public function ancestors($path, $level = null) {
		return $this->node($path, self::DIRECTION_UP, $level);
	}
	
	final public function parents($path) {
		return $this->ancestors($path, 1);
	}

}
