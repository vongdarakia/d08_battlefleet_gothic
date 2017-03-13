<?php 
require_once 'essentials.php';

function saveGame($game, $gameFile, $gameDir = "../private") {
	if (!file_exists($gameDir)) {
		mkdir($gameDir);
	}
	$game = serialize($game);
	file_put_contents($gameFile, $game);
}

function loadGame($gameFile) {
	if (file_exists($gameFile))
		return unserialize(file_get_contents($gameFile));
	return false;
}
?>