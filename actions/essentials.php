<?php 
function sendOK($msg = "") {
	header("HTTP/1.1 200 OK");
	exit();
}

function sendError($msg = "") {
	header('HTTP/1.1 500 Internal Server Error');
	echo $msg;
	exit();
}

// Checks if it's the players turn. If not, then exit.
function playerCheck( $game, $playerID ) {
	if (!$game->isPlayerTurn($playerID)) {
		sendError("Not your turn!");
	}
}
?>