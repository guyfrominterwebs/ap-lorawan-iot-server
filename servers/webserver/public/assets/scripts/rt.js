var initiators = initiators || [];

initiators.push (
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

function RtLineChart () {

	var self = this,
		smoothie = new SmoothieChart ({ millisPerPixel: 50, grid: { strokeStyle: '#4fff4f', lineWidth: 1, verticalSections: 6 }, labels: { fontSize: 18, precision: 6 }, responsive: true }),
		feeds = Object.create (null);

	this.setCanvas = function (node) {
		if (node instanceof jQuery) {
			node = node [0];
		}
		smoothie.streamTo (node, 1000);
		smoothie.resize ();
	};

	this.addFeed = function (id, colour, lineType) {
		// TODO: Line type support. (Solid, dashed, dotted, ...);
		var feed = new TimeSeries ();
		feeds [id] = Object.create (null);
		feeds [id][lineType] = feed;
		smoothie.addTimeSeries (feed, { lineWidth: 1.7, strokeStyle: colour });
	};

	this.removeFeedsById = function (id) {
		// TODO: See how to remove a timeseries from smoothie.
		for (var n in feeds [id]) {
			smoothie.removeTimeSeries (feeds [id][n]);
		}
		delete feeds [id];
	};

	this.removeFeedsByType = function (type) {
		// TODO: See how to remove a timeseries from smoothie.
		for (var n in feeds [id]) {
			smoothie.removeTimeSeries (feeds [id][n]);
			delete feeds [n][type];
		}
	};

	this.addData = function (id, type, data) {
		// TODO: Figure out how time should be handled.
		if (feeds [id] && feeds [id][type]) {
			feeds [id][type].append (Date.now (), data);
		}
	};

}