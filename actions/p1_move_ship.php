<?php 
require_once 'get_game.php';

$dist = intval($_POST['distance']);		// 0 (default)
$shipID = intval($_POST['ship_id']);
$ship = $game->getShipByID($shipID);

if ($ship) {
	if ($ship->moveShip($distance, $game->getMap())) {
		$game->updateMap();
		saveGame($game, $gameFile);
		header("Content-Type: application/json");
		echo json_encode($game);
		exit();
	}
}
sendError();
?>