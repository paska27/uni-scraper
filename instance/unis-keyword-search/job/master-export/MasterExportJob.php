<?php
namespace UnisKeywordSearch\Job;

use UniScraper\Frame\IRunable;

class MasterExportJob implements IRunable {
	public function run() {
		$fileDataSet = service('storage')->readAllJobsExport();
		
		$exports = array();
		foreach ($fileDataSet as $data) {
			$exports[] = service('import')->read($data);
		}
		
		service('export')->writeMasterExport($exports);
	}
}