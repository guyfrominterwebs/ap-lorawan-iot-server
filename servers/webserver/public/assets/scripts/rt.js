var modules = modules || [];

modules.push (
	window.rt = function rt () {
		var self = this,
			feed = $ ('#rt-feed'),
			smoothie = new SmoothieChart ({ maxValue: 1, minValue: 0, grid: { strokeStyle: '#4fff4f', verticalSections: 6 }, labels: { fontSize: 20, precision: 6 } }),
			has_feed = feed.length === 1,
			feeds = [];

		if (has_feed) {
			smoothie.streamTo (feed [0], 1000);
			// Data
			var line1 = new TimeSeries ();
			var line2 = new TimeSeries ();
			feeds.push (line1);
			feeds.push (line2);
			smoothie.addTimeSeries (line1, { lineWidth: 1.7, strokeStyle: "#00FF00" });
			smoothie.addTimeSeries (line2, { lineWidth: 1.7, strokeStyle: "#FF0000" });
			// Add a random value to each line every second
			setInterval (function () { self.receiveData (1) }, 1000);

			// Add to SmoothieChart
		}

		this.receiveData = function receiveData (data) {
			if (has_feed) {
				var time = Date.now ();
				var  i = 0, count = feeds.length;
				var val = 0, asd = 0, mod = 0.01;
				for (; i < count; ++i) {
					val = Math.random ();
					asd = Math.random ();
						feeds [i].append (time, val);
				}
			}
		}
	}
);