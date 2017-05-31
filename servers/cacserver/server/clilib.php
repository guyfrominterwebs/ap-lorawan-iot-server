<?php

function parseCommand (string $command) : array {
	$temp = explode (' ', $command);
	$commands = [];
	$current = null;
	$value = '';
	$count = count ($temp);
	for ($i = 0; $i < $count; ++$i) {
		$c = $temp [$i];
		if (is_numeric ($c)) {
			if ($current !== null) {
				$current [] = $c;
			}
		} else {
			if ($current !== null) {
				$commands [$value] = $current;
			}
			$value = $c;
			$current = [];
		}
		if ($i + 1 === $count && !empty ($value)) {
			$commands [$value] = $current;
		}
	}
	return $commands;
}

function hasSilent (array $args) {
	return isset ($args ['s']);
}

function hasSingle (array $args) {
	return isset ($args ['i']);
}

function hasHelp (array $args) {
	return isset ($args ['h']);
}

function getRepeat (array $args) {
	$keys = [
		'r',
		'R',
		'repeat'
	];
	return getValue ($args, $keys, 1);
}

function getDelay (array $args) {
	$keys = [
		'd',
		'D',
		'delay'
	];
	return getValue ($args, $keys, 1);
}

function getValueRange (array $args) {
	$keys = [
		'range'
	];
	$range = getValuePair ($args, $keys, [ 0, 1 ]);
	$range [0] = trim ($range [0], '\'"');
	$range [1] = trim ($range [1], '\'"');
	if (!is_numeric ($range [0]) || !is_numeric ($range [1])) {
		$range [0] = 0;
		$range [1] = 1;
	}
	$range [0] = (int)$range [0];
	$range [1] = (int)$range [1];
	return $range;
}

function getRandomCount ($args) {
	return getValue ($args, [ 'random' ], 0);
}

function getValue (array $args, array $keys, int $default) : int {
	$value = $default;
	foreach ($keys as $key) {
		if (isset ($args [$key]) && is_array ($args [$key]) && count ($args [$key]) === 1) {
			$value = $args [$key][0];
			break;
		}
	}
	return $value;
}

function getValuePair (array $args, array $keys, array $default) : array {
	$value = $default;
	foreach ($keys as $key) {
		if (isset ($args [$key]) && is_array ($args [$key]) && count ($args [$key]) === 2) {
			$value = $args [$key];
			break;
		}
	}
	return $value;
}

function outHelp () {
	$halp = [
		's' => [
			"Silent mode, no user input required beside command line arguments."
		],
		'h' => [
			"Displays this help message."
		],
		'temperature' => [
			"A temperature value.",
			'fakeTemperature'
		],
		'light' => [
			"A light value",
			'fakeLight'
		]
	];
}

function runArgs (array $args, string $device, bool $single, int $random, array $range) : array {
	$commands = [];
	foreach ($args as $command => $values) {
		if (is_string ($values)) {
			$values = [ $values ];
		} else if (empty ($values)) {
			continue;
		}
		if ($random > 0) {
			if ($single) {
				for ($i = 0; $i < $random; ++$i) {
					if (!empty ($temp = commandToInternal ($command, $device, [ randomValue ($range [0], $range [1]) ]))) {
						$commands [] = $temp;
					}
				}
			} else {
				$values = [];
				for ($i = 0; $i < $random; ++$i) {
					$values [] = randomValue ($range [0], $range [1]);
				}
				if (!empty ($temp = commandToInternal ($command, $device, $values))) {
					$commands [] = $temp;
				}
			}
		} else {
			if ($single) {
				foreach ($values as $value) {
					if (!empty ($temp = commandToInternal ($command, $device, [ $value ]))) {
						$commands [] = $temp;
					}
				}
			} else {
				if (!empty ($temp = commandToInternal ($command, $device, $values))) {
					$commands [] = $temp;
				}
			}
		}
	}
	return $commands;
}
