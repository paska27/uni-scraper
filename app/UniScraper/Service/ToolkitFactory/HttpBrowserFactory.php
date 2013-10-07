<?php
namespace UniScraper\Service\ToolkitFactory;

use UniScraper\Service\AbstractFactory;
use Guzzle\Http\Client as GuzzleClient;
use UniScraper\Toolkit\Browser\Http\Browser;

class HttpBrowserFactory extends AbstractFactory
{
	const ARG_BASE_URL = 'base_url';

	public function build() {
		$guzzleClient = new GuzzleClient();

		$browser = new Browser();
		$browser->setClient($guzzleClient);

		if (isset($this->args[self::ARG_BASE_URL])) {
			$browser->setBaseUrl($this->args[self::ARG_BASE_URL]);
		}

		return $browser;
	}

}