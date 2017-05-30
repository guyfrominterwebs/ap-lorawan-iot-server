<?php



function deviceHwId (int $index) : string {
	$devices = [
		'0039ABFB7C0F69F5',
		'000E787235DE2EAB',
		'001FBF0B3F51D1A2'
	];
	if (isset ($devices [$index])) {
		return $devices [$index];
	} return '0';
}
