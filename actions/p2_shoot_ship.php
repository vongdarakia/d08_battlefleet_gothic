<?php 
require_once 'get_game.php';

// $playerID = isset($_GET['player_id']) ? intval($_GET['player_id']) : 0;
// playerCheck($game, $playerID);

$weaponID 	= isset($_GET['weapon_id']) ? intval($_GET['weapon_id']) : 0;
$shipID 	= isset($_GET['ship_id']) ? intval($_GET['ship_id']) : 0;
$ship 		= $game->getShipByID($shipID);
$ship 		= $game->getShipByID($shipID);

if ($ship) {
	$weapon = $ship->getWeaponByID($weaponID);
	if ($weapon) {
		if ($weapon->shoot($game->getMap())) {
			saveGame($game, $gameFile);
			sendOK("Shot something!");
		}
		sendError("Can't shoot");
	}
	sendError("Weapon doesn't exist");
}
sendError("Invalid ship ID");
?>