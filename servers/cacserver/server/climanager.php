<?php

/*
	CLI management functions.
*/
 
function readInput () {
	echo 'Input command: ';
	return trim (fgets (fopen ('php://stdin', 'r')));
}
