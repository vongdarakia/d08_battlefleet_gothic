<?php 
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

function sendError() {
	header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
	exit();
}
?>