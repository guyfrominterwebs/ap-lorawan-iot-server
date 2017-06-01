'use strict';
var initiators = initiators || [];

// TODO: More flexible way to provide list of devices and measurement values.
window.graphModels = $ ('#graph-models');
window.graphChannel = null;

initiators.push (function () {
	prepareGraphs ();
	prepareCommunication ();
});

function prepareGraphs () {
	// TODO: Some checks prior to start up to ensure browser compatability and presence of required dom structures.
	if (window.graphModels.length === 0) {
		// Model elements not present; rendering not possible unless they are added.
	}
	if (!devices || !Array.isArray (devices)) {
		return;
	}
	var graphMan = window.graphMan = new GraphManager ();
	var i = 0,
		count = devices.length,
		container = $ ('#graph-container'),
		last = $ ('<div/>', { class: 'container' });
	if (count === 0) {
		return;
	}
	container.prepend (last);
	for (; i < count; ++i) {
		graphMan.newGraph (last, devices [i]._id, devices [i]._id + ' (' + devices [i].dev_id + ')');
		if (i + 1 < count) {
			last = $ ('<div/>', { class: 'container' }).insertAfter (last);
		}
	}
}

function prepareCommunication () {
	graphChannel = new RTSocket (receiveData, '*', '*');
	graphChannel.connect ();
}

function receiveData (data) {
	graphMan.addData (JSON.parse (data));
}

function GraphManager (_allowNew, _domContainer) {

	var self = this,
		allowNew = false,
		graphs = {};

	this.newGraph = function (container, device, heading) {
		var graph = new Graph (),
			view = new GraphView (heading);
		graph.addItem (device);
		view.setGraph (graph);
		view.setContainer (container);
		graphs [device] = graph;
		return graph;
	};

	this.addData = function (data) {
		var i = 0, count = data.values.length;
		if (!graphs [data.device]) {
			if (!allowNew) {
				return;
			}
			// self.newGraph (); // Do dis
		}
		var graph = graphs [data.device];
		for (; i < count; ++i) {
			for (var value in data.values [i]) {
				graph.addType (value);
				graph.addData (data.device, value, data.values [i][value]);
			}
		}
	};

}

GraphManager.toggleGraph = function (event) {
	var target = $ (event.currentTarget),
		body = target.closest ('.graph-layout').find ('.graph-body');
	if (body.is (':visible')) {
		target.html ('&#x22C1;');
		body.slideUp ();
	} else {
		target.html ('&#x22C0;');
		body.slideDown ();
	}
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
			populateNode ();
			return true;
		}
		return false;
	};

	function applyGraph () {
		var types = graph.getTypes ();
		var items = graph.getItems ();
		for (var n in types) {
			addType (types [n]);
		}
		for (var n in items) {
			addItem (items [n]);
		}
	}

	function addItem (item) {
		if (itemLines [item]) {
			return;
		}
		var types = graph.getTypes ();
		itemLines [item] = GraphView.line_types [colour_counter];
		if (node) {
			itemsGraphical (node.find (".graph-body .line-table"));
		}
		for (var n in types) {
			chart.addFeed (item, typeLines [types [n]], itemLines [item]);
		}
		++colour_counter;
		if (GraphView.line_types.length <= colour_counter) {
			colour_counter = 0;
		}
	}

	function addType (type) {
		// TODO: Update type type once line type support has been added.
		if (typeLines [type]) {
			return;
		}
		var items = graph.getItems ();
		typeLines [type] = GraphView.line_colours [type_counter];
		if (node) {
			typesGraphical (node.find (".graph-body .legend-table"));
		}
		for (var n in items) {
			chart.addFeed (items [n], typeLines [type], itemLines [items [n]]);
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
		layout.find ('.graph-heading h4').text (heading);
		itemsGraphical (layout.find (".graph-body .line-table"));
		typesGraphical (layout.find (".graph-body .legend-table"));
		node.html (layout);
		sizeCanvas (canvas)
		chart.setCanvas (canvas);
	}

	function itemsGraphical (table) {
		if (!graph || !table) {
			return;
		}
		var itemLine = window.graphModels.find (".line-entry"),
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

	function typesGraphical (table) {
		if (!graph || !table) {
			return;
		}
		var valueLegend = window.graphModels.find (".legend-entry"),
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