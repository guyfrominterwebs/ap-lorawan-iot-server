<?php

namespace Lora;

use \Lora\DAO as DAO;
use \Lora\Server\Command as Command;

/**
	TODO: Maybe add a buffer for failed broadcasts so that they can be sent later on again.
	A singleton based class for managing MQTT connection to The Things Network and broadcasting 
	data to the system.
*/

class DataServer
{

	private static $instance;

	private $mqtt_client 		= null,
			$rt_client 			= null,
			$rt_address 		= '',
			$allowPrint			= true;

	private function __construct () {
		$this->rt_address = "ws://localhost:".Config::port ('server', 'internal_messaging');
	}

	public static function instance () : \Lora\DataServer {
		return self::$instance ?? (self::$instance = new self);
	}

	/**
		Start the server loop. This is a blocking wait function.
	*/
	public function start () : void {
		$this->print ("Establishing TTN connection.");
		if (!$this->MQTTConnect ()) {
			$this->print ("Could not establish connection to TTN.");
			return;
		}
		$this->print ("Connection to TTN server established. Subscribing to channels...");
		$topics ['#'] = [
			"qos" => 0,
			"function" => "\Lora\DataServer::processMessage"
		];
		$this->mqtt_client->subscribe ($topics);
		// $this->mqtt_client->debug = true;
		$this->print ("Subscribing complete. Listening for messages.".PHP_EOL);
		while ($this->mqtt_client->proc ());
		$this->mqtt_client->close ();
		$this->rt_client->close ();
	}

	/**
		A static entry point to message processing routine. Performs primitive validity checks on data types 
		to see if it is the data is even remotely processable. Proper data sanity checks are done later.
		\param $topic Topic of the MQTT message.
		\param $msg Message received from the MQTT server.
	*/
	public static function processMessage ($topic, $msg) : void {
		$temp = self::instance ();
		if (!is_string ($topic) || !is_string ($msg) || !DataLib::isJson ($msg)) {
			$temp->print ("Invalid message received.");
			return;
		}
		$messages = $temp->process ($topic, $msg);
		$temp->printAll ($messages);
	}

	/**
		Main processing method. Parses, stores and broadcasts the received data.
		\param $topic Topic of the MQTT messagae.
		\param $msg Message received from the MQTT server.
		\return An array of messages is returned describing the processing of the message.
	*/
	public function process (string $topic, string $msg) : array {
		$messages = [];
		$messages [] = "Message received: ".date ("r")."\nTopic:${topic}\n${msg}\n";
		if (!$this->parseReceived ($topic, $msg, $parsedTopic, $parsedMsg)) {
			$messages [] = "Failed to parse message.";
			return $messages;
		}
		if (strtolower ($parsedMsg ['msg']['payload']) === 'heartbeat') {
			return $messages;
		}
		$parsedMsg ['topic'] = $parsedTopic;
		$this->insert ($parsedMsg ['device']['_id'], $parsedMsg);
		$this->broadcast ($parsedMsg ['msg'], $messages);
		return $messages;
	}

	/**
		\todo Internal message processing (terminate).
		Broadcasts a received message to other server systems. Only interested one at the moment is the 
		realtime sever which in turn broadcasts it onwards to clients who are interested in it.
		\param $msg Parsed MQTT message payload with device id and time stamp.
		\param $messages Messages array to allow this method add messages about the data processing.
		\return Returns true if the data was succesfully broadcasted and false if not.
	*/
	private function broadcast (array $msg, array &$messages) : bool {
		if (!$this->rt_client) {
			$messages [] = "Establishing realtime server connection; {$this->rt_address}";
			if (!$this->rtConnect ()) {
				$messages [] = "Could not establish realtime connection.";
				return false;
			}
			$messages [] = "Realtime connection established.";
		}
		$messages [] = "Broadcasting data.";
		$data = InternalMSG::composeMsg (Command::DATA, $msg);
		if (!$this->rt_client->send ($data)) {
			if (!$this->rt_client->isConnected ()) {
				$messages [] = "Realtime client connection error: ".$this->rt_client->lastError ();
			}
			return false;
		}
		$this->rt_client->receive ($response);
		if ($response === 'terminate') {
			$this->rt_client->close ();
			return false;
		}
		$messages [] = "Response: ${response}";
		return true;
	}

	/**
		Parses the topic and message received from the MQTT server into more flexible form for this class to use.
		\param $topic Topic received from the MQTT server.
		\param $msg Message receieved from the MQTT server.
		\param[out] $parsedTopic An array to which the parsed topic data will be set. Set to null if it cannot be parsed.
		\param[out] $parsedMsg An array to which the parsed message data will be set. Set to null if it cannot be parsed.
		\return Returns true if parsing was succesful and false if not.
	*/
	private function parseReceived (string $topic, string $msg, array &$parsedTopic, array &$parsedMsg) : bool {
		$msg = json_decode ($msg, true);
		$parsedTopic = $this->parseTopic ($topic);
		$parsedMsg = $this->parseMessage (new \RequestData ($msg));
		return $parsedTopic !== null && $parsedMsg !== null;
	}

	/**
		Parses MQTT topic string into an associative array.
		\param $topic An MQTT topic.
		\return Returns an associative array containing the topic information.
	*/
	private function parseTopic (string $topic) : array {
		$topic = explode ('/', $topic);
		$keys = [
			'application',
			'source',
			'device',
			'message',
			'event'
		];
		foreach ($topic as $key => $value) {
			if (!isset ($keys [$key])) {
				continue;
			}
			$topic [$keys [$key]] = $value;
			unset ($topic [$key]);
		}
		return $topic;
	}

	/**
		Parses the MQTT messaage and ensures precense of required value as well as their type correctness.
		\param $req An instance of RequestData wrapping the MQTT message.
		\return Returns a nullable array. An array of parsed data is returned on success and null 
			if the message cannot be parsed.
	*/
	private function parseMessage (\RequestData $req) : ?array {
		$required = [
			'metadata',
			'dev_id',
			'hardware_serial',
			'payload_raw'
		];
		$requiredMeta = [
			'time'
		];
		if (!$req->has ($required)) {
			return $this->parseActivation ($data);
		}
		if ($req->readArray ('metadata', $meta)) {
			return null;
		}
		$meta = new RequestData ($meta);
		if (!$meta->has ($requiredMeta)) {
			return null;
		}
		$req->readString ('dev_id', $devId, '');
		$req->readString ('hardware_serial', $hwId, '');
		$payload = $this->parsePayload ($req->getString ('payload_raw', ''));
		$datetime = DateTime::createFromFormat ('Y-m-d\TH:i:s+', $meta->getString ('time', ''));
		if ($datetime === false || $payload === null || !DataLib::isHexString ($hwId)) {
			return null;
		}
		$result = [
			'device' => [
				'_id'				=> $hwId,
				'dev_id'			=> $devId,
				'hardware_serial'	=> $hwId
			],
			'msg' => [
				'device_id'			=> $hwId,
				'time'				=> $datatime->getTimestamp (),
				'payload'			=> $payload
			]
		];
		return $result;
	}

	/**
		A case specific parser for an activation message. DataServer::parseMessage cannot 
		parse this without unreasonably large changes so it is wrapped as its own function.
		\param $req An instance of RequestData wrapping the MQTT message.
		\return Returns a nullable array. An array of parsed data is returned on success and null 
			if the message cannot be parsed.
	*/
	private function parseActivation (\RequestData $req) : ?array {
		$required = [
			'dev_eui'
		];
		$hwId = $req->getString ('dev_eui', '');
		if (!$req->has ($required) || !DataLib::isHexString ($hwId)) {
			return null;
		}
		return [ 'device' => [ '_id' => $hwId ] ];
	}

	/**
		A method to parse the raw payload data from the MQTT server.
		\param $payload Raw payload string in base64 encoded form.
		\return Returns null on failure and an array of associative arrays 
			containing type value pairs of the measured values.
	*/
	private function parsePayload (string $payload) : ?array {
		if (($payload = base64_decode ($payload)) === false) {
			return null;
		}
		$data = explode ('|', $payload);
		$result = [];
		foreach ($data as $key => $entry) {
			if (empty ($entry)) {
				unset ($data [$key]);
				continue;
			}
			$type = substr ($entry, 0, 3);
			$value = substr ($entry, 3);
			$result [] = [ $type => floatval ($value) ];
		}
		return $result;
	}

	private function rtConnect () {
		if ($this->rt_client) {
			return true;
		}
		$this->rt_client = new \WebSocket\Client ($this->rt_address);
		return $this->rt_client->connect ();
	}

	private function MQTTConnect () : bool {
		if ($this->mqtt_client) {
			return $this->mqtt_client;
		}
		$configs = parse_ini_file ('configs/ttn.ini');
		$this->mqtt_client = new \phpMQTT ($configs ['address'], 1883, 'nasty'.rand ());
		return $this->mqtt_client->connect (true, null, $configs ['app_id'], $configs ['access_key']);
	}

	/**
		A context aware method for inserting data into database. Checks for the presence of certain values 
		in $data and uses that information to determine if data should be inserted or not.
		\param $deviceId Device hardware id.
		\param $data An array containing parsed MQTT originated data.
		\return Returns true on success and false if an erro occured.
	*/
	private function insert (string $deviceId, array $data) : bool {
		$result = DAO::insertDevice ($deviceId);
		if (isset ($data ['msg'])) {
			$result &= DAO::insertRaw ($data);
		}
		if (isset ($data ['msg']['payload'], $data ['msg']['time'])) {
			$result &= DAO::insertMeasurement ($deviceId, $data ['msg']['time'], $data ['msg']['payload']);
		}
		return $result;
	}

	private function print ($msg, $eol = true) : void {
		if ($this->allowPrint) {
			msg_print ($msg);
		}
	}

	private function printAll (array $msgs) : void {
		foreach ($msgs as $msg) {
			$this->print ($msg);
		}
	}
}
