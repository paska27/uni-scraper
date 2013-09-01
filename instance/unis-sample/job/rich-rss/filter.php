<?php

function rating(string $html, array $rates) {
	preg_match('#class=["\'](\d+)-star#i', $html, $matches);
	
	$stars = (int) $matches[1];
	
	return $rates[$stars];
}