<?php
define('PATH_APP', __DIR__ .'/../app/');
define('PATH_VENDOR', __DIR__ .'/../vendor/');

require_once PATH_VENDOR . '/symfony/class-loader/Symfony/Component/ClassLoader/UniversalClassLoader.php';

use Symfony\Component\ClassLoader\UniversalClassLoader;

$loader = new UniversalClassLoader();

$loader->registerNamespaces(array(
	'UniScraper' => PATH_APP,

	// handy abstract browser wrapper
	'Symfony\Component\BrowserKit' => PATH_VENDOR . 'symfony/browser-kit',
	// used in browser kit
	// @todo: possibly for hooks as well?
	'Symfony\Component\EventDispatcher' => PATH_VENDOR . 'symfony/event-dispatcher',
	// used by ServiceProvider
	'Symfony\Component\DependencyInjection' => PATH_VENDOR . 'symfony/dependency-injection',
	// DOM traversing tool
	'Symfony\Component\DomCrawler' => PATH_VENDOR . 'symfony/dom-crawler',
	'Symfony\Component\Config' => PATH_VENDOR . 'symfony/configuration',

	// http client wrapper realisation using guzzle
	'Goutte' => PATH_VENDOR . 'goutte',
	// actual http (and not only) client
	'Guzzle' => PATH_VENDOR . 'guzzle/src',
	
));

$loader->register();