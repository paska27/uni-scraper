<?php
namespace UniScraper\Service\Config;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class UnisConfig extends JsonConfig
{
	public function setValidatorTree(TreeBuilder $tree) {
		$root = 'unis';
		$tree->root($root)
			->children()
				->arrayNode('toolkit')
					->children()
						->enumNode('browser')
							->values(array('http', 'js'))
						->end()
						->enumNode('parser')
							->values(array('html', 'json'))
						->end()
						->enumNode('extractor')
							->values(array('html', 'regex'))
						->end()
					->end()
				->end()
				->arrayNode('service')->end()
			->end()
		;
		return $root;
	}
}