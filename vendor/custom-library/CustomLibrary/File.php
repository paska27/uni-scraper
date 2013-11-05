<?php
namespace CustomLibrary;
/**
 * Class File
 *
 * @package CustomLibrary
 */
class File
{
	/**
	 * @copyright (c)
	 * Recursive glob()
	 * $Id: rglob.php,v 1.0 2008/11/24 17:20:00 hm2k Exp $
	 * 
	 * @param string $path
	 * @param string $pattern
	 * @param int $flags
	 * 
	 * @return array $files
	 */
	public static function rglob($path, $pattern = '*', $flags = 0) {
		//@todo: refactor so pattern only is used including case with {}
		$paths = glob($path . '*', GLOB_MARK|GLOB_ONLYDIR|GLOB_NOSORT|GLOB_BRACE);
		$files = glob($path . $pattern, $flags);
		foreach ($paths as $path) {
			$files = array_merge($files, self::rglob($path, $pattern, $flags));
		}
		return $files;
	}

	/**
	 * Recursive rglob for directories.
	 *
	 * @param string $path
	 * @param string $pattern
	 * @param int $flags
	 * @return array
	 */
	public static function rglobdir($path, $pattern = '*', $flags = 0) {
		return self::rglob($path, $pattern, GLOB_ONLYDIR|$flags);
	}

	/**
	 * @param string $path
	 * @param string $prefix
	 * @return string $path
	 */
	public static function prefixAbsolutePath($path, $prefix) {
		if (isset($path[0]) && in_array($path[0], array('/', '\\'))) {
			$path = rtrim($prefix, '/\\') . DIRECTORY_SEPARATOR . substr($path, 1);
		}
		return $path;
	}
}