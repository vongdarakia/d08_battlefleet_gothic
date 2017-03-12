<?php 
require_once 'get_game.php';
$dist = intval($_POST['distance']);		// 0 (default)
$rot = intval($_POST['rotation']);		// 0 nothing (default), -1 counter, 1 clockwise 90
$shipID = intval($_POST['ship_id']);

$ship = $game->getShipByID($shipID);

if ($ship) {
	// If ship is not stationary, that means it moved the previous turn.
	// so we have to move straight the distance of its handle value.
	if (!$ship->isStationary()) {
		$ship->moveShip($ship->getHandle(), $game->getMap());
	}

	$ship->turnShip($rot);

	if ($dist === 0) {
		$ship->setMoved(false);
		return ;
	}
	
	$ship->moveShip($distance, $game->getMap());

	$game->updateMap();
	saveGame($game, $gameFile);
	header("Content-Type: application/json");
	echo json_encode($game);
	exit();
}
else {
	sendError();
	// echo "Invalid ship ID: '" . $_POST['ship_id'] . "'";
}
?>