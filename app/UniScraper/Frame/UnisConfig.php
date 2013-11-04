<?php
namespace UniScraper\Frame;

use UniScraper\Utility\Config\File\JsonConfig;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class UnisConfig extends JsonConfig
{
	public static function processServiceArgs($args, $pathApp) {
		$args = \CustomLibrary\XArray::from(!empty($args) ? $args->toArray() : array());

		// prefix paths with pathApp
		$args = $args->mapr(function($v, $k, $d) {return \CustomLibrary\File::prefixAbsolutePath($v, $d);}, $pathApp);

		return $args->toArray();
	}
	
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
				->arrayNode('service')
					->prototype('array')
						->children()
							->scalarNode('type')->isRequired()->end()
							->arrayNode('args')
								->prototype('variable')->end()
							->end()
						->end()
					->end()
				->end()
			->end()
		;
		return $root;
	}
}