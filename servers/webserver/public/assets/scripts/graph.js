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
	view.setContainer (container);
	view.setGraph (graph);
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
		types			= [],
		viewer			= null;

	this.addItem = function (item) {
		// Add entry to items.
		var index = items.indexOf (item);
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

	this.addType = function (type) {
		// Add entry to types
		var index = types.indexOf (type);
		if (index === -1) {
			types.push (type);
			if (viewer) {
				viewer.onType (type, true);
			}
		}
	};

	this.removeType = function (type) {
		var index = types.indexOf (type);
		if (index !== -1) {
			types.splice (index, 1);
			if (viewer) {
				viewer.onType (type, false);
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

	this.getTypes = function () {
		return types;
	};

	this.attachModel = function (model) {
		viewer = model;
	};

	this.detachModel = function () {
		viewer = null;
	};
}

function GraphView (_heading) {

	var self				= this,
		node				= null,
		graph				= null,
		visible				= true,
		heading				= _heading,
		itemLines			= {},
		typeLines			= {},
		colour_counter		= 0,
		type_counter		= 0,
		chart				= new RtLineChart ();

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
		chart.addData (item, typeLines [type], data);
	};

	this.onItem = function (item, added) {
		// NOTE: Added could be replaced with presence check.
		if (added) {
			addItem (item);
		} else {
			chart.removeFeedsById (item);
			delete itemLines [item];
		}
	};

	this.onType = function (type, added) {
		// NOTE: Added could be replaced with presence check.
		if (added) {
			addType (type);
		} else {
			chart.removeFeedsByType (type);
			delete typeLines [type];
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
		var types = graph.getTypes ();
		var items = graph.getItems ();
		for (var n in types) {
			addType (types [n], true);
		}
		for (var n in items) {
			addItem (items [n]);
		}
		for (var n in types) {
			addType (types [n]);
		}
	}

	function addItem (item, noFeed) {
		if (itemLines [item]) {
			return;
		}
		var types = graph.getTypes ();
		itemLines [item] = GraphView.line_types [colour_counter];
		itemsGraphical ();
		if (!noFeed) {
			for (var n in types) {
				chart.addFeed (item, typeLines [types [n]], itemLines [item]);
			}
		}
		++colour_counter;
		if (GraphView.line_types.length <= colour_counter) {
			colour_counter = 0;
		}
	}

	function addType (type, noFeed) {
		// TODO: Update type type once line type support has been added.
		if (typeLines [type]) {
			return;
		}
		var items = graph.getItems ();
		typeLines [type] = GraphView.line_colours [type_counter];
		typesGraphical ();
		if (!noFeed) {
			for (var n in items) {
				chart.addFeed (items [n], typeLines [type], itemLines [items [n]]);
			}
		}
		++type_counter;
		if (GraphView.line_colours.length <= type_counter) {
			type_counter = 0;
		}
	}

	function populateNode () {
		// TODO: More flexible item and type categories.
		var layout = window.graphModels.find (".graph-layout").clone (),
			canvas = layout.find ('canvas');
		if (graph) {
			layout.find ('.graph-heading h4').text (heading);
			itemsGraphical (layout.find (".line-table"));
			// var itemLine = window.graphModels.find (".line-entry"),
				// valueLegend = window.graphModels.find (".legend-entry"),
				// table = layout.find (".line-table"),
				// items = graph.getItems (),
				// line = null,
				// box = null;
			// for (var n in items) {
				// line = itemLine.clone ();
				// line.html ('Device: ' + items [n]);
				// box = $ ('<div/>', { class: 'line-colour-box' }).css ('background-color', itemLines [items [n]]);
				// table.append (line.append (box));
			// }
			// table = layout.find (".legend-table");
			// items = graph.getTypes ();
			// for (var n in items) {
				// line = valueLegend.clone ();
				// line.html (typeLines [items [n]] + ': ' + items [n]);
				// table.append (line);
			// }
			typesGraphical (layout.find (".legend-table"));
		}
		node.html (layout);
		sizeCanvas (canvas)
		chart.setCanvas (canvas);
	}

	function itemsGraphical () {
		if (!graph || !node) {
			return;
		}
		var table = node.find (".line-table"),
			itemLine = window.graphModels.find (".line-entry"),
			items = graph.getItems ();
		if (!table || table.length === 0) {
			return;
		}
		table.empty ();
		for (var n in items) {
			table.append (itemLine.clone ().html (itemLines [items [n]] + ': ' + items [n]));
		}
		return table;
	}

	function typesGraphical () {
		if (!graph || !node) {
			return;
		}
		var table = node.find (".legend-table"),
			valueLegend = window.graphModels.find (".legend-entry"),
			types = graph.getTypes (),
			box = null;
		if (!table || table.length === 0) {
			return;
		}
		table.empty ();
		for (var n in types) {
			box = $ ('<div/>', { class: 'line-colour-box' }).css ('background-color', typeLines [types [n]]);
			table.append (valueLegend.clone ().html (types [n]).prepend (box));
		}
		return table;
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
	"Solid",
	"More solid"
];