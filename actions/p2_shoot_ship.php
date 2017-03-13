<?php 
require_once 'get_game.php';

// $playerID = isset($_GET['player_id']) ? intval($_GET['player_id']) : 0;
// playerCheck($game, $playerID);

$weaponID 	= isset($_GET['weapon_id']) ? intval($_GET['weapon_id']) : 1;
$shipID 	= isset($_GET['ship_id']) ? intval($_GET['ship_id']) : 1;
$ship 		= $game->getShipByID($shipID);

if ($ship) {
	$weapon = $ship->getWeaponByID($weaponID);
	// $player2 = $game->getPlayerByID(2);
	// $ship2 = $player2->getShips()[0];
	// $ship2->setXY(5, 0);
	// $game->updateMap();

	if ($weapon) {
		if ($weapon->shoot($game->getMap())) {
			$game->updateMap();
			saveGame($game, $gameFile);
			sendOK("Shot something!");
		}
		sendError("Can't shoot");
	}
	sendError("Weapon doesn't exist");
}
sendError("Invalid ship ID");
?>