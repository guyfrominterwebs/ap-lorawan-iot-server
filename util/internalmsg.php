<?php

use \Lora\Server\Command as Command;

class InternalMSG
{

	public static function buildMsg (Command $command, array $message) : string {
		return "$command:".json_encode ($message);
	}

}