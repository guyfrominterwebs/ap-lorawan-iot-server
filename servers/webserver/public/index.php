<?php
$before = microtime (true);
require '../main.php';
echo microtime (true) - $before, 's';
