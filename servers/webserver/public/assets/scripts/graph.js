'use strict';
var initiators = initiators || [];

// TODO: More flexible way to provide list of devices and measurement values.
window.graphModels = $ ('#graph-models');
var graph = null;
initiators.push (function () {
	// TODO: Some checks prior to start up to ensure browser compatability and presence of required dom structures.
	if (window.graphModels.length === 0) {
		// Model elements not present; rendering not possible unless they are added.
	}
	return;
	var container = $ ('#graph-container').prepend ($ ('<div/>', { class: 'container' }));
	newGraph ($ ('#graph-container .container:last'), 'Graph 1');
	$ ($ ('<div/>', { class: 'container' })).insertAfter (container.find ('.container:last'));
	newGraph ($ ('#graph-container .container:last'), 'Graph 2');
	$ ($ ('<div/>', { class: 'container' })).insertAfter (container.find ('.container:last'));
	newGraph ($ ('#graph-container .container:last'), 'Graph what?');
	$ ($ ('<div/>', { class: 'container' })).insertAfter (container.find ('.container:last'));
	newGraph ($ ('#graph-container .container:last'), 'I\'m your father Luke.');
});

function newGraph (container, heading) {
	graph = new Graph (heading);
	graph.addItem (devices [0]);
	var view = new GraphView (heading);
	view.setGraph (graph);
	view.setContainer (container);
	return graph;
}

function GraphManager () {

	var self = this,
		grahps = [];

	this.newGraph = function () {
		return new Graph ();
	};

}

function Graph () {

	var self			= this,
		items			= [],
		values			= [],
		viewer			= null;

	this.addItem = function (item) {
		// Add entry to items.
		var index = items.indexOf ();
		if (index === -1) {
			items.push (item);
			if (viewer) {
				viewer.onItem (item, true);
			}
		}
	};

	this.removeItem = function (item) {
		var index = items.indexOf (item);
		if (index !== -1) {
			items.splice (index, 1);
			if (viewer) {
				viewer.onItem (item, false);
			}
		}
	};

	this.addValue = function (value) {
		// Add entry to values
		var index = values.indexOf (value);
		if (index === -1) {
			values.push (value);
			if (viewer) {
				viewer.onValue (value, true);
			}
		}
	};

	this.removeValue = function (value) {
		var index = values.indexOf (value);
		if (index !== -1) {
			values.splice (index, 1);
			if (viewer) {
				viewer.onValue (value, false);
			}
		}
	};

	this.addData = function (item, type, data) {
		if (viewer) {
			viewer.onData (item, type, data);
		}
	};

	this.getItems = function () {
		return items;
	};

	this.getValues = function () {
		return values;
	};

	this.attachModel = function (model) {
		viewer = model;
	};

	this.detachModel = function () {
		viewer = null;
	};
}

function GraphView (_heading) {

	var self			= this,
		node			= null,
		graph			= null,
		visible			= true,
		heading			= _heading,
		itemColours		= {},
		valueLines		= {},
		colour			= 0,
		type			= 0,
		chart			= new RtLineChart ();

	this.hide = function () {
		visible = false;
	};

	this.show = function () {
		visible = true;
	};

	this.setGraph = function (_graph) {
		if (_graph instanceof Graph) {
			if (graph) {
				graph.detachModel ();
			}
			graph = _graph;
			graph.attachModel (self);
			applyGraph ();
		}
	};

	this.onData = function (item, type, data) {
		chart.addData (item, valueLines [type], data);
	};

	this.onItem = function (item, added) {
		// NOTE: Added could be replaced with presence check.
		if (added) {
			addItem (item);
		} else {
			chart.removeFeedsById (item);
			delete itemColours [item];
		}
	};

	this.onValue = function (value, added) {
		// NOTE: Added could be replaced with presence check.
		if (added) {
			addValue (value);
		} else {
			chart.removeFeedsByType (value);
			delete valueLines [value];
		}
	};

	this.setContainer = function (_node) {
		if (typeof _node === "string") {
			_node = $ (_node);
			if (_node.length !== 1) {
				return false;
			}
		}
		if (_node instanceof jQuery) {
			node = _node;
			populateNode (_node);
			return true;
		}
		return false;
	};

	function applyGraph () {
		var values = graph.getValues ();
		var items = graph.getItems ();
		for (var n in values) {
			addValue (values [n], true);
		}
		for (var n in items) {
			addItem (items [n]);
		}
		for (var n in values) {
			addValue (values [n]);
		}
	}

	function addItem (item, noFeed) {
		if (itemColours [item]) {
			return;
		}
		var values = graph.getValues ();
		itemColours [item] = GraphView.line_colours [colour];
		if (!noFeed) {
			for (var n in values) {
				chart.addFeed (item, itemColours [item], valueLines [values [n]]);
			}
		}
		++colour;
		if (GraphView.line_colours.length <= colour) {
			colour = 0;
		}
	}

	function addValue (value, noFeed) {
		// TODO: Update type value once line type support has been added.
		if (valueLines [value]) {
			return;
		}
		var items = graph.getItems ();
		valueLines [value] = GraphView.line_types [type];
		valuesGraphical ();
		if (!noFeed) {
			for (var n in items) {
				chart.addFeed (items [n], itemColours [items [n]], valueLines [value]);
			}
		}
		++type;
		if (GraphView.line_types.length <= type) {
			type = 0;
		}
	}

	function populateNode () {
		// TODO: More flexible item and value categories.
		var layout = window.graphModels.find (".graph-layout").clone (),
			canvas = layout.find ('canvas');
		if (graph) {
			layout.find ('.graph-heading h4').text (heading);
			var itemLine = window.graphModels.find (".line-entry"),
				valueLegend = window.graphModels.find (".legend-entry"),
				table = layout.find (".line-table"),
				items = graph.getItems (),
				line = null,
				box = null;
			for (var n in items) {
				// TODO: Generate legend node from item n
				line = itemLine.clone ();
				line.html ('Device: ' + items [n]);
				box = $ ('<div/>', { class: 'line-colour-box' }).css ('background-color', itemColours [items [n]]);
				table.append (line.append (box));
			}
			// table = layout.find (".legend-table");
			// items = graph.getValues ();
			// for (var n in items) {
				// // TODO: Generate line node from item n
				// line = valueLegend.clone ();
				// line.html (valueLines [items [n]] + ': ' + items [n]);
				// table.append (line);
			// }
			valuesGraphical (layout.find (".legend-table"));
		}
		node.html (layout);
		sizeCanvas (canvas)
		chart.setCanvas (canvas);
	}

	function valuesGraphical (table) {
		if (!graph || !node) {
			return;
		}
		var table = node.find (".legend-table") || table,
			valueLegend = window.graphModels.find (".legend-entry"),
			values = graph.getValues ();
		if (!table) {
			return;
		}
		table.empty ();
		for (var n in values) {
			table.append (valueLegend.clone ().html (valueLines [values [n]] + ': ' + values [n]));
		}
	}

	function sizeCanvas (canvas) {
		// var wrapper = canvas.parent ();
		// canvas.height (wrapper.height ())
		// canvas.width (wrapper.width ())
	}
}

GraphView.line_colours = [
	'#00FF00',
	'#FF00FF',
	'#1100FF',
	'#FF0011',
	'#FFFF00'
];

GraphView.line_types = [
	"Solid"
];