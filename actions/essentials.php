<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set('America/Los_Angeles');

$gameFile = "../private/game";

function sendOK( $msg = "" ) {
	header("HTTP/1.1 200 OK");
	echo $msg;
	exit();
}

function sendError( $msg = "" ) {
	header('HTTP/1.1 500 Internal Server Error');
	echo $msg;
	exit();
}

function sendJSON( $json ) {
	header("Content-Type: application/json");
	echo json_encode($json);
	exit();
}

// Checks if it's the players turn. If not, then exit.
function playerCheck( $game, $playerID ) {
	if (!$game->isPlayerTurn($playerID)) {
		sendError("Not your turn!");
	}
}
?>