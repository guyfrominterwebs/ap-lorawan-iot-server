var modules = modules || [];

function start () {
	console.log (modules);
	var i = 0, l = modules.length;
	for (; i < l; ++i) {
		modules [i] ();
	}
}