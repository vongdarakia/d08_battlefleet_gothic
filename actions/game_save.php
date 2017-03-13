<?php 
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