<?php

/*
	CLI management functions.
*/
 
function readInput () {
	echo 'Input command: ';
	return fgets (fopen ('php://stdin', 'r'));
}
