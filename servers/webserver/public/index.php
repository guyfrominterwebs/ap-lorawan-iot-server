<?php
$before = microtime (true);
require '../main.php';
if (debug ()) {
	echo microtime (true) - $before, 's';
}
