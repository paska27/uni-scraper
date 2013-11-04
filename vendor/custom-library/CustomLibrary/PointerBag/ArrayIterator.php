<?php
namespace CustomLibrary\PointerBag;

use ArrayIterator as PhpArrayIterator;

class ArrayIterator extends PhpArrayIterator
{
	public function current() {
		$current = parent::current();
		return is_array($current) ? new ReadableBag($current) : $current;
	}
}