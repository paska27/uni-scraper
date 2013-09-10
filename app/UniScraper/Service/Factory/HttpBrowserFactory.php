<?php
namespace UniScraper\Service\Factory;

use Guzzle\Http\Client as GuzzleClient;
use UniScraper\Toolkit\Browser\Http\Browser;

class HttpBrowserFactory implements IFactory {
	const SERVICE_NAME = 'http_browser';
	const ARGKEY_BASE_URL = 'base_url';

	/**
	 *
	 * @var array
	 */
	private $arguments;
	
	public function __construct($arguments) {
		$this->arguments = $arguments;
	}

	public function produce() {
		$guzzleClient = new GuzzleClient();

		$browser = new Browser();
		$browser->setClient($guzzleClient);

		if (isset($this->arguments[self::ARGKEY_BASE_URL])) {
			$browser->setBaseUrl($this->arguments[self::ARGKEY_BASE_URL]);
		}

		return $browser;
	}

}