<?php 
require_once 'get_game.php';

$playerID = isset($_POST['player_id']) ? intval($_POST['player_id']) : 0;
playerCheck($game, $playerID);

$ppSpeed 	= isset($_POST['speed']) ? intval($_POST['speed']) : 0;
$ppShield 	= isset($_POST['shield']) ? intval($_POST['shield']) : 0;
$ppWeapon 	= isset($_POST['weapon']) ? intval($_POST['weapon']) : 0;
$ppRepair 	= isset($_POST['repair']) ? intval($_POST['repair']) : 0;
$shipID 	= isset($_POST['ship_id']) ? intval($_POST['ship_id']) : 0;
$ship 		= $game->getShipByID($shipID);

if ($ship) {
	$ship->spendPP($ppSpeed, $ppShield, array($ppWeapon), $ppRepair);
	saveGame($game, $gameFile);
	header("Content-Type: application/json");
	echo json_encode($game);
}
else {
	sendError("Invalid ship ID");
}
?>