<?php
namespace UnisKeywordSearch\Toolkit;

class FileStorage {
	const FILE_NAME_TPL = 'd.m.Y_His.excel';
	
	public function __construct() {
		
	}
	
	public function writeJobExport($fileData, $jobDir) {
		$path = strtr(JOB_EXPORT_DIR, array('[job_name]' => basename($jobDir)));
		$this->write($fileData, $path);
	}
	
	public function writeMasterExport($fileData) {
		$this->write($fileData, MASTER_EXPORT_DIR);
	}
	
	private function write($fileData, $path) {
		$filename = $path . date(self::FILE_NAME_TPL);
		file_put_contents($filename, $fileData);
	}
	
	public function readAllJobExports() {
		$pattern = strtr(JOB_EXPORT_DIR, array('[job_dir]' => '!{master-export}'));
		$fileDataSet = glob($pattern);
		
		return $fileDataSet;
	}
	
	private function read($filename) {
		if (!file_exists($filename)) {
			throw new \Exception("No export file '$filename' found!");
		}
		
		$fileData = file_get_contents($filename);
		return $fileData;
	}

}
