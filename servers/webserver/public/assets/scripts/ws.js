'use strict';
var initiators = initiators || [];

// TODO:
//	- Device and value subscribing.
//	- Delegate registering.

function RTSocket (_handler, _devices, _values) {

	var self 			= this,
		socket 			= null,
		closing 		= false,
		handler			= _handler,
		devices			= _devices,
		values			= _values;

	this.getHandler = function () {
		return handler;
	};

	this.connect = function () {
		try {
			socket = new WebSocket ("ws://" + window.location.hostname + ":9000");
			socket.onopen = function () {
				self.onopen ();
			};
			socket.onmessage = function (event) {
				self.onmessage (event);
			};
			socket.onclose = function (event) {
				self.onclose (event);
			};
			socket.onerror = function (error) {
				self.onerror (error);
			};
		} catch (exception) {
			console.error (exception);
		}
	};

	this.subscribe = function (_handler, _devices, _values) {
		var changed = false;
		if (_handler && handler != _handler) {
			handler = _handler;
			changed = true;
		}
		if (_devices && devices != _devices) {
			devices = _devices;
			changed = true;
		}
		if (_values && values != _values) {
			values = _values;
			changed = true;
		}
		if (changed && socket) {
			socket.send (JSON.stringify ({ devices: devices, values: values }));
		}
	};

	this.close = function () {
		closing = true;
		socket.close ();
	};

	this.fakeMsg = function (msg) {
		self.onmessage (msg);
	};

	this.onopen = function () {
		console.log ("Opened;" + socket.readyState);
		self.subscribe (handler, devices, values);
	}

	this.onmessage = function (event) {
		console.log (event.data);
		var temp = handler || self.getHandler ();
		if (temp) {
			temp (event.data);
		}
	}

	this.onclose = function (event) {
		if (!closing) {
			setTimeout (function () {
				self.connect ();
			}, 10000);
		}
		socket.onclose = function () {};
		socket.close ()
		console.log ("Closed;" + socket.readyState);
		closing = false;
		socket = null;
	}

	this.onerror = function (err) {
		console.error ('Web socket connection error.');
	}
}
