<?php

class CountRestosJob extends AbstractJob {
	private $countsDir;
	
	public function __construct()
	{
		$this->countsDir = __DIR__ . '/'.  $this->spec('counts_dir');
	}
	
	public function run() {
		$this->getCounts();
		$this->storeResults();
	}
	
	private function getCounts() {
		foreach ($this->targetedCities as $city) {
			$url = $this->specBuildUrl('all_restos_url', array('city' => $city));
			$this->browse($url);

			$this->parse($this->spec('node_restos_groups'));

			// in this case nodes will be list of siblings
			// so extractor by default will get info from their 'text' property
			$this->extract();

			foreach ($this->records as $rcd) {
				$group = $rcd->text;
				$url = $this->spaceBuildUrl('all_restos_url', array('city' => $city, 'group' => $group));
				$this->browse();

				$this->parse('node_restos');

				$this->saveCityCount($city, $group, (int) count($this->nodes));
			}
		}
	}
	
	/**
	 * Results:
	 * array(
	 *		array(
	 *			'city' => 'London'
	 *			'group' => array(
	 *				'Orient' => 10000,
	 *				'Western' => 25000,
	 *				'Russian' => 5000
	 *			),
	 *			'total' => 40000
	 *		),
	 *		...,
	 *		total => 700000
	 * );
	 */
	private function storeResults() {
		$json = json_encode($this->counts);
		file_put_contents($this->countsDir . '/' . date('Y-m-d_H-i-s') . '.json', $json);
	}
}