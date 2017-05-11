var initiators = initiators || [];

var dev_graph = null;
var heading = "Test graph for devices view.";
var container = $ ('#graph-container').prepend ($ ('<div/>', { class: 'container' }));
var channel = null;

initiators.push (function () {
	dev_graph = newGraph (container, heading);
	channel = new RTSocket ();
	channel.subscribe (broadcastData, '*', '*');
	setInterval (some_data, 2000);
});

function some_data () {
	Math.random ()
	channel.fakeMsg ({ device: devices [0], value: 0, data: Math.random () });
}

function broadcastData (data) {
	dev_graph.addData (data.device, data.value, data.data);
}
