<?php
namespace UniScraper\Toolkit\Browser;

use Guzzle\Http\Client as GuzzleClient;
use Goutte\Client as GoutteClient;
use Symfony\Component\BrowserKit\Response as SymfonyResponse;

class HttpBrowser extends GoutteClient {
	
	/**
	 *
	 * @var GuzzleClient
	 */
	protected $client;

	/**
	 *
	 * @var SymfonyResponse
	 */
	protected $response;
	
	/**
	 * @return GuzzleClient
	 */
	public function getClient() {
		return $this->client;
	}
	
	public function setBaseUrl($url) {
		$this->client->setBaseUrl($url);
	}
	
	public function browse($url = null) {
		if (empty($url)) {
			if (!($url = $this->client->getBaseUrl(false/*expand*/))) {
				throw new Exception("No url to browse!");
			}
		}
		$this->request('GET', $url);
		return $this->getPage();
	}
	
	public function getPage() {
		return $this->response->getContent();
	}
	
	public function navigate($path, $query = array()) {
		return $this->browse($this->baseUrl . trim($path, '/'));
	}
	
	public function post() {
		// do post
	}
}