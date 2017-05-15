var initiators = initiators || [];

initiators.push (
	function () {
		if (!("WebSocket" in window)) {
			return;
		}
		var socket = new RTSocket ();
		socket.connect ();
});

// TODO:
//	- Device and value subscribing.
//	- Delegate registering.

function RTSocket (_parser, _devices, _values) {

	var self 			= this,
		socket 			= null,
		closing 		= false,
		parser			= _parser,
		devices			= _devices,
		values			= _values;

	this.connect = function () {
		socket = new WebSocket ("ws://" + window.location.hostname + ":9000");
		try {
			socket.onopen = onopen;
			socket.onmessage = onmessage;
			socket.onclose = onclose;
			socket.onerror = onerror;
		} catch (exception) {
			console.error (exception);
		}
	};

	this.subscribe = function (_parser, _devices, _values) {
		var changed = false;
		if (_parser && parser != _parser) {
			parser = _parser;
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
		onmessage ({ data: msg });
	};

	function onopen () {
		console.log ("Opened;" + socket.readyState);
		self.subscribe (parser, devices, values);
	}

	function onmessage (event) {
		console.log (event.data);
		parser (event.data);
	}

	function onclose (event) {
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

	function onerror (err) {
		console.error ('Web socket connection error.');
	}
}
