var modules = modules || [];

modules.push (
	function ws () {
		if ("WebSocket" in window) {
			connect ();
		}
		function connect () {
			try {
				var feed = $ ('#rt-feed'),
					has_feed = feed.length === 1,
					rtsocket = new WebSocket ("ws://127.0.0.1:9000"),
					closing = false;

				rtsocket.onopen = function () {
					console.log ("Opened;" + rtsocket.readyState);
				}
				rtsocket.onmessage = function (e) {
					console.log (e, has_feed);
					if (has_feed) {
						feed.append ("<p>" + e.data + "</p>");
					}
				}
				rtsocket.onclose = function(e){
					if (!closing) {
						setTimeout (function () {
							connect ();
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
		}
});