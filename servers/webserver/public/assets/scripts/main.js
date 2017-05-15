var initiators = initiators || [];

function start () {
	console.log (initiators);
	var i = 0, l = initiators.length;
	for (; i < l; ++i) {
		initiators [i] ();
	}
}