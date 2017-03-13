<?php 
require_once 'get_game.php';

// $playerID = isset($_GET['player_id']) ? intval($_GET['player_id']) : 0;
// playerCheck($game, $playerID);

$dist = isset($_GET['distance']) ? intval($_GET['distance']) : 0; 
$shipID = isset($_GET['ship_id']) ? intval($_POST['ship_id']) : 0; 
$ship = $game->getShipByID($shipID);

if ($ship) {
	if ($ship->moveShip($dist, $game->getMap())) {
		$game->updateMap();
		saveGame($game, $gameFile);
		sendJSON($game);
	}
	sendError("Can't move");
}
sendError("Invalid ship ID");
?>