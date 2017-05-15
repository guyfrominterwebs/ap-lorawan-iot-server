var initiators = initiators || [];

var dev_graph = null;
var heading = "Test graph for devices view.";
var container = $ ('#graph-container').prepend ($ ('<div/>', { class: 'container' }));
var channel = null;

initiators.push (function () {
	dev_graph = newGraph (container, heading);
	channel = new RTSocket (receiveData, '*', '*');
	// channel.subscribe (receiveData, '*', '*');
	// setInterval (some_data, 2000);
	channel.connect ();
});

function some_data () {
	Math.random ()
	channel.fakeMsg ({ device: devices [0], value: 0, data: Math.random () });
}

function broadcastData (data) {
	dev_graph.addData (data.device, data.value, data.data);
}

function receiveData (data) {
	var data = JSON.parse (data);
	var i = 0, count = data.values.length;
	dev_graph.addItem (data.device);
	for (; i < count; ++i) {
		for (var value in data.values [i]) {
			dev_graph.addValue (value);
			dev_graph.addData (data.device, value, data.values [i][value]);
		}
	}
}
