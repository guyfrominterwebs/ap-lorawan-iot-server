'use strict';

function RtLineChart () {

	var self = this,
		smoothie = new SmoothieChart ({ millisPerPixel: 50, grid: { strokeStyle: '#4fff4f', lineWidth: 1, verticalSections: 6 }, labels: { fontSize: 18, precision: 6 }, responsive: true, yRangeFunction: chartYBoundaries }),
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
		feeds [id] = feeds [id] || Object.create (null);
		feeds [id][colour] = feed;
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

	function chartYBoundaries (boundaries) {
		boundaries.min--;
		boundaries.max++;
		return boundaries;
	}

}