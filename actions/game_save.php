<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set('America/Los_Angeles');

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

function sendOK() {
	header("HTTP/1.1 200 OK");
	exit();
}

function sendError($msg = "") {
	header('HTTP/1.1 500 Internal Server Error');
	echo $msg;
	exit();
}
?>