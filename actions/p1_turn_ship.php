<?php 
	require_once 'get_game.php';

	$rot = intval($_POST['rotation']);		// 0 nothing (default), -1 counter, 1 clockwise 90
	$shipID = intval($_POST['ship_id']);

	$ship = $game->getShipByID($ship_id);
	
	if ($ship->turnShip($rot, $game->getMap())) {
		sendOK();
	}
	else {
		sendError();
	}
?>