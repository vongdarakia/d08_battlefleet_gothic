<?php 
require_once 'get_game.php';

// player_id
// ship_id
// weapon_id
$ship = $game->getShipByID($_POST["ship_id"]);
if ($ship) {
	$weapon = $ship->getWeaponByID($_POST["weapon_id"]);
	if ($weapon) {
		$weapon->shoot($game->getMap());
		saveGame($game, $gameFile);
		sendOK();
	}
}
sendError():
?>