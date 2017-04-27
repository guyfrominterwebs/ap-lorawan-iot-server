<?php

/**
 * Copyright (C) 2014, 2015 Textalk
 * Copyright (C) 2015 Patrick McCarren - added payload fragmentation for huge payloads
 *
 * This file is part of Websocket PHP and is free software under the ISC License.
 * License text: https://raw.githubusercontent.com/Textalk/websocket-php/master/COPYING
 */

namespace WebSocket;

class Base
{

	public const CONTINUATION 			= 0;
	public const TEXT 					= 1;
	public const BINARY 				= 2;
	public const CLOSE 					= 8;
	public const PING 					= 9;
	public const PONG 					= 10;

	protected $socket,
			  $is_connected 			= false,
			  $is_closing 				= false,
			  $last_opcode 				= null,
			  $close_status 			= null,
			  $huge_payload 			= null;

	protected static $opcodes = [ 0, 1, 2, 8, 9, 10 ];

	public function lastError () {
		return socket_strerror (socket_last_error ($this->socket));
	}

	public function getLastOpcode()	{
		return $this->last_opcode;
	}
	public function getCloseStatus() {
		return $this->close_status;
	}
	public function isConnected() {
		return $this->is_connected;
	}

	public function setTimeout($timeout) {
		$this->options ['timeout'] = $timeout;
		if ($this->socket && get_resource_type ($this->socket) === 'Socket') {
			socket_set_option ($this->socket, SOL_SOCKET, SO_RCVTIMEO, [ 'sec' => $this->options ['timeout'], 'usec' => 0 ]);
		}
	}

	public function setFragmentSize($fragment_size) {
		$this->options ['fragment_size'] = $fragment_size;
		return $this;
	}

	public function getFragmentSize() {
		return $this->options ['fragment_size'];
	}

	public function send(string $payload, int $opcode = self::TEXT, bool $masked = true) {
		if (!$this->is_connected) {
			return null;
		}
		// record the length of the payload
		$payload_length = strlen ($payload);
		$fragment_cursor = 0;
		$attempts = 0;
		// while we have data to send
		while ($payload_length > $fragment_cursor && $attempts < 10) {
			// get a fragment of the payload
			$sub_payload = substr ($payload, $fragment_cursor, $this->options ['fragment_size']);
			// advance the cursor
			$fragment_cursor += $this->options ['fragment_size'];
			// is this the final fragment to send?
			$final = $payload_length <= $fragment_cursor;
			// send the fragment
			if ($this->send_fragment ($sub_payload, $final, $opcode, $masked) === false) {
				$fragment_cursor -= $this->options ['fragment_size'];
				++$attempts;
			}
			// all fragments after the first will be marked a continuation
			$opcode = self::CONTINUATION;
		} return true;
	}

	protected function send_fragment(string $payload, bool $final, int $opcode, bool $masked) {
		// Binary string for header.
		$frame_head_binstr = '';
		// Write FIN, final fragment bit.
		$frame_head_binstr .= (bool)$final ? '1' : '0';
		// RSV 1, 2, & 3 false and unused.
		$frame_head_binstr .= '000';
		// Opcode rest of the byte.
		$frame_head_binstr .= sprintf ('%04b', $opcode);
		// Use masking?
		$frame_head_binstr .= $masked ? '1' : '0';
		// 7 bits of payload length...
		$payload_length = strlen ($payload);
		if ($payload_length > 65535) {
			$frame_head_binstr .= decbin (127);
			$frame_head_binstr .= sprintf ('%064b', $payload_length);
		} else if ($payload_length > 125) {
			$frame_head_binstr .= decbin (126);
			$frame_head_binstr .= sprintf ('%016b', $payload_length);
		} else {
			$frame_head_binstr .= sprintf ('%07b', $payload_length);
		}
		$frame = '';
		// Write frame head to frame.
		foreach (str_split ($frame_head_binstr, 8) as $binstr) {
			$frame .= chr (bindec ($binstr));
		}
		// Handle masking
		if ($masked) {
			// generate a random mask:
			$mask = '';
			for ($i = 0; $i < 4; $i++) {
				$mask .= chr (rand (0, 255));
			}
			$frame .= $mask;
		}
		// Append payload to frame:
		for ($i = 0; $i < $payload_length; $i++) {
			$frame .= ($masked === true) ? $payload [$i] ^ $mask [$i % 4] : $payload [$i];
		}
		return $this->write ($frame);
	}

	public function receive(&$response) {
		if (!$this->is_connected) {
			return null;
		}
		$this->huge_payload = '';
		$response = null;
		while ($response === null) {
			if (($response = $this->receive_fragment ()) === false) {
				return false;
			}
		}
		return true;
	}

	protected function receive_fragment() {
		// Just read the main fragment information first.
		$data = $this->read (2);
		if ($data === false) {
			return false;
		}
		// Is this the final fragment?	// Bit 0 in byte 0
		/// @todo Handle huge payloads with multiple fragments.
		$final = (boolean)(ord ($data [0]) & 1 << 7);
		// Should be unused, and must be false…	// Bits 1, 2, & 3
		$rsv1	= (boolean)(ord ($data [0]) & 1 << 6);
		$rsv2	= (boolean)(ord ($data [0]) & 1 << 5);
		$rsv3	= (boolean)(ord ($data [0]) & 1 << 4);
		// Parse opcode
		$opcode = ord ($data [0]) & 31; // Bits 4-7
		if (!in_array ($opcode, self::$opcodes)) {
			return false;
		}
		// record the opcode if we are not receiving a continutation fragment
		if ($opcode !== self::CONTINUATION) {
			$this->last_opcode = $opcode;
		}
		// Masking?
		$mask = (boolean)(ord ($data [1]) >> 7);	// Bit 0 in byte 1
		$payload = '';
		// Payload length
		$payload_length = (integer)ord ($data [1]) & 127; // Bits 1-7 in byte 1
		if ($payload_length > 125) {
			if ($payload_length === 126) {
				$data = $this->read (2); // 126: Payload is a 16-bit unsigned int
			} else {
				$data = $this->read (8); // 127: Payload is a 64-bit unsigned int
			}
			if ($data === false) {
				return false;
			}
			$payload_length = bindec (self::sprintB ($data));
		}
		// Get masking key.
		if ($mask) {
			$masking_key = $this->read (4);
			if ($masking_key === false) {
				return false;
			}
		}
		// Get the actual payload, if any (might not be for e.g. close frames.
		if ($payload_length > 0) {
			$data = $this->read ($payload_length);
			if ($data === false) {
				return false;
			}
			if ($mask) {
				// Unmask payload.
				for ($i = 0; $i < $payload_length; $i++) {
					$payload .= ($data [$i] ^ $masking_key [$i % 4]);
				}
			} else {
				$payload = $data;
			}
		}
		if ($opcode === self::CLOSE) {
			// Get the close status.
			if ($payload_length >= 2) {
				$status_bin = $payload [0].$payload [1];
				$status = bindec (sprintf ("%08b%08b", ord ($payload [0]), ord ($payload [1])));
				$this->close_status = $status;
				$payload = substr ($payload, 2);
				if (!$this->is_closing) {
					$this->send ($status_bin.'Close acknowledged: '.$status, self::CLOSE, true); // Respond.
				}
			}
			if ($this->is_closing) {
				$this->is_closing = false; // A close response, all done.
			}
			// And close the socket.
			// fclose ($this->socket);
			socket_close ($this->socket);
			$this->is_connected = false;
		}
		// if this is not the last fragment, then we need to save the payload
		if (!$final) {
			$this->huge_payload .= $payload;
			return null;
		} else if ($this->huge_payload) { // this is the last fragment, and we are processing a huge_payload
			// sp we need to retreive the whole payload
			$payload = $this->huge_payload .= $payload;
			$this->huge_payload = null;
		} return $payload;
	}

	protected function disconnect () {
		if ($this->socket) {
			socket_close ($this->socket);
			$this->socket = null;
			$this->is_connected = false;
		}
	}

	/**
	 * Tell the socket to close.
	 *
	 * @param integer $status	http://tools.ietf.org/html/rfc6455#section-7.4
	 * @param string	$message A closing message, max 125 bytes.
	 */
	public function close($status = 1000, $message = 'ttfn') {
		if (!$this->is_connected) {
			return null;
		}
		$status_binstr = sprintf ('%016b', $status);
		$status_str = '';
		foreach (str_split ($status_binstr, 8) as $binstr) {
			$status_str .= chr (bindec ($binstr));
		}
		$this->send ($status_str.$message, self::CLOSE, true);
		$this->is_closing = true;
		$this->receive ($response); // Receiving a close frame will close the socket now.
		return $response;
	}

	protected function write($data) {
		if (!$this->is_connected) {
			return false;
		}
		if (($written = socket_write ($this->socket, $data)) === false) {
			$this->disconnect ();
		} return strlen ($data) - $written === 0;
	}

	protected function read($length) {
		$data = '';
		$attempts = 0;
		$read = 0;
		while ($read < $length) {
			if (($read = @socket_recv ($this->socket, $buffer, $length, 0)) === false || (strlen ($data) === 0 && $attempts++ > 10)) {
				$this->is_connected = false;
				return false;
			}
			$data .= $buffer;
		} return $data;
	}

	protected function readUntil (string $sequence) {
		$data = '';
		$buffer = '';
		$attempts = 0;
		while (($pos = strpos ($buffer, $sequence)) === false) {
			if ($read = socket_recv ($this->socket, $buffer, 1024, 0) === false || (strlen ($data) === 0 && $attempts++ > 10)) {
				return false;
			}
			$data .= $buffer;
		} return substr ($data, 0, $pos + strlen ($sequence));
	}

	/**
	 * Helper to convert a binary to a string of '0' and '1'.
	 */
	protected static function sprintB($string) {
		$return = '';
		for ($i = 0; $i < strlen ($string); $i++) {
			$return .= sprintf ("%08b", ord ($string [$i]));
		} return $return;
	}
}
