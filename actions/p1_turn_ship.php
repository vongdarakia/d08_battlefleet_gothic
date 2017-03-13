<?php 
require_once 'get_game.php';

// $playerID = isset($_GET['player_id']) ? intval($_GET['player_id']) : 0;
// playerCheck($game, $playerID);

// 0 nothing (default), -1 counter, 1 clockwise 90
$rot = isset($_GET['rotation']) ? intval($_GET['rotation']) : 0; 
$shipID = isset($_GET['ship_id']) ? intval($_GET['ship_id']) : 0; 
$ship = $game->getShipByID($shipID);

if ($ship) {
	if ($ship->turnShip($rot, $game->getMap())) {
		$game->updateMap();
		saveGame($game, $gameFile);
		sendJSON($game);
	}
	sendError("Can't turn");
}
sendError("Invalid ship ID");
?>