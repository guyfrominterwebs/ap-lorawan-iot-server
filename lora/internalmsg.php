<?php

use \Lora\Server\Command as Command;

/**
	A messaging utility class used to unify and manage internal messaging within various server subsystems.
*/
class InternalMSG
{

	/**
		Composes an encoded message used for internal messaging within the server complex.
		\param $command One of the Command constants.
		\param $message An array containing relevant data for this command.
		\return Returns a formatted message string.
	*/
	public static function composeMsg (int $command, array $message) : string {
		return "$command:".json_encode ($message);
	}

	/**
		Decomposes an encoded message and decodes it into useable component. 
		If the message cannot be decoded, an invalid message array is returned 
		with Command::INVALID in its 0 index and nothing in 1 index.
		\param $msg Message to decode.
		\return Returns an array containing the decoded message. 0 index holds the Command -value and 1 index the decoded message.
	*/
	public static function decomposeMsg (string $msg) : array {
		if (($pos = strpos ($message, ':')) === false || ($command = DataLib::isInt (substr ($message, 0, $pos))) === false || !Command::isCommand ($command)) {
			return [ Command::INVALID ];
		}
		return [
			$command,
			json_decode (substr ($message, $pos + 1))
		];
	}
}
