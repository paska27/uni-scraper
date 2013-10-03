<?php
namespace UniScraper\Service\Config;

class JsonConfig extends AbstractFileConfig
{
	protected function parseData($data) {
		if (!($data = json_decode($data, true /*assoc*/))) {
			throw new \Exception('Could not load data, error: ' . json_last_error_msg());
		}
		return $data;
	}
}