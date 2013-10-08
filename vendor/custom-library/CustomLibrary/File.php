<?php
namespace CustomLibrary;

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
		$paths = glob($path . '*', GLOB_MARK|GLOB_ONLYDIR|GLOB_NOSORT|GLOB_BRACE);
		$files = glob($path . $pattern, $flags);
		foreach ($paths as $path) {
			$files = array_merge($files, self::rglob($path, $pattern, $flags));
		}
		return $files;
	}
}