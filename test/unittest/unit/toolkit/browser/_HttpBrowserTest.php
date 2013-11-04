<?php
namespace UniScraper\Unittest\Unit\Toolkit\Browser;

use UniScraper\Unittest\BaseTestCase;
use Guzzle\Http\Client;
use UniScraper\Toolkit\Browser\HttpBrowser;

require_once 'autoload.php';

class _HttpBrowserTest extends BaseTestCase
{
	const BROWSER_NAMESPACE = '\UniScraper\Toolkit\Browser\HttpBrowser';
	
	public function testCreateBrowser() {
		$client = new Client();
		
		$browser = new HttpBrowser();
		$browser->setClient($client);
		
		$this->assertInstanceOf(self::BROWSER_NAMESPACE, $browser);
		
		return $browser;
	}
	
	/**
	 * @depends testCreateBrowser
	 */
	public function testDoRequest(HttpBrowser $browser) {
		$url = 'http://ya.ru';
		
		$page = $browser->browse($url);
		
		$this->assertTrue(is_string($page));
		$this->assertNotEmpty($page);
		$this->assertFalse(empty($page));
	}

}