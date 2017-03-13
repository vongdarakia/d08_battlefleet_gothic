<?php 
require_once 'get_game.php';

$playerID = isset($_POST['player_id']) ? intval($_POST['player_id']) : 0;
playerCheck($game, $playerID);

// 0 nothing (default), -1 counter, 1 clockwise 90
$rot = isset($_POST['rotation']) ? intval($_POST['rotation']) : 0; 
$shipID = isset($_POST['ship_id']) ? intval($_POST['ship_id']) : 0; 
$ship = $game->getShipByID($shipID);

if ($ship) {
	if ($ship->turnShip($rot, $game->getMap())) {
		$game->updateMap();
		saveGame($game, $gameFile);
		header("Content-Type: application/json");
		echo json_encode($game);
		exit();
	}
}
sendError();
?>