<?php
namespace UniScraper;

use UniScraper\Frame\Builder;

class UniScraper
{
	protected $pathApp;
	
	/**
	 *
	 * @var Builder
	 */
	protected $builder;

	public function __construct($pathApp) {
		$this->pathApp = rtrim($pathApp, '/\\') . DIRECTORY_SEPARATOR;
		
		$this->builder = new Builder($pathApp);
		$this->builder->run();
	}
	
	public function runJobs() {
		\CustomLibrary\XArray::from(\CustomLibrary\File::rglob($this->pathApp . 'job/*'))
			->filter(function($v){ return strpos($v, 'Job.php') !== false ; })
			->loop(function($file){
				require $file;
				$class = basename($file, '.php');
				
				$job = new $class();
				$job->run();
			})
			;
	}

}