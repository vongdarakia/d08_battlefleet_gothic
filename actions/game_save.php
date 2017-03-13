<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set('America/Los_Angeles');
require_once 'essentials.php';

function saveGame($game, $gameFile) {
	$game = serialize($game);
	file_put_contents($gameFile, $game);
}

function loadGame($gameFile) {
	if (file_exists($gameFile))
		return unserialize(file_get_contents($gameFile));
	else
		echo "File doesn't exist";
}
?>