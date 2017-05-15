<?php

use \Lora\Server\Command as Command;

class InternalMSG
{

	/**
		$command One of the Command constants.
		$message An array containing relevant data for this command.
	*/
	public static function buildMsg (int $command, array $message) : string {
		return "$command:".json_encode ($message);
	}

}
