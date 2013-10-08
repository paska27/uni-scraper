<?php
namespace UniScraper\Utility\Config\File;

class JsonConfig extends AbstractFileConfig
{
	protected function parseData($data) {
		if (!($data = json_decode($data, true /*assoc*/))) {
			throw new \Exception('Could not parse json data, error code: ' . json_last_error());
		}
		return $data;
	}
}