<?php

namespace Lora;

use \Lora\DAO as DAO;
use \Lora\Server\Command as Command;

class DataServer
{

	private static $instance;
	private $mqtt_client 		= null,
			$rt_client 			= null,
			$rt_address 		= '',
			$allowPrint			= true;

	private function __construct () {
		$this->rt_address = "ws://localhost:".Config::get ('server', 'intern_port');
	}

	public static function instance () : \Lora\DataServer {
		return self::$instance ?? (self::$instance = new self);
	}

	public function start ($loop = true) {
		$topics ['#'] = [
			"qos" => 0,
			"function" => "\Lora\DataServer::processMessage"
		];
		$this->print ("Establishing TTN connection.");
		if (!$this->MQTTConnect ()) {
			$this->print ("Could not establish connection to TTN.");
			return false;
		}
		$this->print ("Connection to TTN server established. Subscribing to channels...");
		$this->mqtt_client->subscribe ($topics);
		// $this->mqtt_client->debug = true;
		$this->print ("Subscribing complete. Listening for messages.".PHP_EOL);
		if ($loop) {
			while ($this->mqtt_client->proc ());
			$this->mqtt_client->close ();
			$this->rt_client->close ();
		}
	}

	public static function processMessage ($topic, $msg) : void {
		$temp = self::instance ();
		if (!is_string ($topic) || !is_string ($msg) || !DataLib::isJson ($msg)) {
			$temp->print ("Invalid message received.");
			return;
		}
		$messages = $temp->process ($topic, $msg);
		$temp->printAll ($messages);
	}

	public function process (string $topic, string $data) : array {
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

	# TODO: Internal message processing (terminate).
	private function broadcast (array $msg, array &$messages) : bool {
		$messages [] = "Broadcasting data.";
		if (!$this->rt_client) {
			$messages [] = "Establishing realtime server connection; {$this->rt_address}";
			if (!$this->rtConnect ()) {
				$messages [] = "Could not establish realtime connection.";
				return false;
			}
			$messages [] = "Realtime connection established.";
		}
		$data = InternalMSG::composeMsg (Command::DATA, $msg);
		if (!$this->rt_client->send ($data)) {
			if (!$this->rt_client->isConnected ()) {
				$messages [] = "Realtime connection client error: ".$this->rt_client->lastError ();
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

	private function parseReceived (string $topic, string $msg, array &$parsedTopic, array &$parsedMsg) {
		$msg = json_decode ($msg, true);
		$parsedTopic = $this->parseTopic ($topic);
		$parsedMsg = $this->parseMessage ($msg);
		return $parsedTopic !== null && $parsedMsg !== null;
	}

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

	private function parseActivation (array $data) : ?array {
		$req = new \RequestData ($data);
		$required = [
			'dev_eui'
		];
		$hwId = $req->getString ('dev_eui', '');
		if (!$req->has ($required) || !DataLib::isHexString ($hwId)) {
			return null;
		}
		return [ 'device' => [ '_id' => $hwId ] ];
	}

	private function parseMessage (array $data) : ?array {
		$req = new \RequestData ($data);
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
		$meta = new RequestData ($data ['metadata']);
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

	private function insert (string $deviceId, array $data) : bool {
		$result = DAO::insertDevice ($deviceId);
		if (isset ($data ['msg'])) {
			$result &= DAO::insertRaw ($data ['msg']);
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
