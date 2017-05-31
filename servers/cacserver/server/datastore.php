<?php



function deviceHwId (int $index) : string {
	$devices = [
		'DEADBEEF09090909',
		'0039ABFB7C0F69F5',
		'0004A30B001B0E5F',
		'00D83C35D3EC4F29',
		'000E787235DE2EAB',
		'008332328E29AA70',
		'001BDA6A82C332C8',
		'00775613D25053CD',
		'001FBF0B3F51D1A2',
		'0050F88B09070A75'
	];
	return isset ($devices [$index]) ? $devices [$index] : '0';
}
