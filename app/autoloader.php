<?php
define('PATH_APP', __DIR__ .'/../app/');
define('PATH_VENDOR', __DIR__ .'/../vendor/');

require_once PATH_VENDOR . '/symfony/class-loader/Symfony/Component/ClassLoader/UniversalClassLoader.php';

use Symfony\Component\ClassLoader\UniversalClassLoader;

$loader = new UniversalClassLoader();

$loader->registerNamespaces(array(
	'UniScraper' => PATH_APP,

	'Symfony\Component\BrowserKit' => PATH_VENDOR . 'symfony/browser-kit',
	'Symfony\Component\EventDispatcher' => PATH_VENDOR . 'symfony/event-dispatcher',

	'Guzzle' => PATH_VENDOR . 'guzzle/src',
));

$loader->register();