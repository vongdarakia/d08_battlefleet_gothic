<?php 
require_once 'get_game.php';

// $playerID = isset($_GET['player_id']) ? intval($_GET['player_id']) : 0;
// playerCheck($game, $playerID);

$ppSpeed 	= isset($_GET['speed']) ? intval($_GET['speed']) : 0;
$ppShield 	= isset($_GET['shield']) ? intval($_GET['shield']) : 0;
$ppWeapon 	= isset($_GET['weapon']) ? intval($_GET['weapon']) : 0;
$ppRepair 	= isset($_GET['repair']) ? intval($_GET['repair']) : 0;
$shipID 	= isset($_GET['ship_id']) ? intval($_GET['ship_id']) : 0;
$ship 		= $game->getShipByID($shipID);

if ($ship) {
	$ship->spendPP($ppSpeed, $ppShield, array($ppWeapon), $ppRepair);
	saveGame($game, $gameFile);
	sendJSON($game);
}
sendError("Invalid ship ID");
?>