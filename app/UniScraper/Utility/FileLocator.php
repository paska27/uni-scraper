<?php
namespace UniScraper\Utility;

use Symfony\Component\Config\FileLocator as SymfonyFileLocator;

class FileLocator extends SymfonyFileLocator
{

	public function __construct($paths = array()) {
		$paths = \CustomLibrary\XArray::from((array) $paths)
			->map(function($v){return (substr($v, -1)=='*') ? \CustomLibrary\File::rglobdir(rtrim($v, '*')) : $v;})
			->expand()
			->toArray();
		parent::__construct($paths);
	}

}