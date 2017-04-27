<?php

/*
	CLI management functions.
*/
 
function getPathsFromStdIn() {
	echo 'Input command: ';
	$stdin = fopen('php://stdin', 'r');
	return fgets ($stdin);
}
