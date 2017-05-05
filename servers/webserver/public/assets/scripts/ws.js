var modules = modules || [];

modules.push (
	function () {
		if (!("WebSocket" in window)) {
			return;
		}
		var socket = new ws ();
		socket.connect ();
});

function ws () {
	var self = this,
		rtsocket = null,
		closing = false,
		rtFeed = new rt ();

	this.connect = function () {
		var rtsocket = self.rtsocket = new WebSocket ("ws://127.0.0.1:9000");
		try {
			rtsocket.onopen = function () {
				console.log ("Opened;" + rtsocket.readyState);
			}
			rtsocket.onmessage = function (e) {
				console.log (e);
				// rtFeed.receiveData (data);
			}
			rtsocket.onclose = function(e){
				if (!closing) {
					setTimeout (function () {
						self.connect ();
					}, 10000);
				}
				rtsocket.onclose = function () {};
				rtsocket.close()
				console.log ("Closed;" + rtsocket.readyState);
				rtsocket = null;
			}
			rtsocket.onerror = function (err) {
				console.error ('Web socket connection error.');
			}
		} catch (exception) {
			console.error (exception);
		}
	};
}
