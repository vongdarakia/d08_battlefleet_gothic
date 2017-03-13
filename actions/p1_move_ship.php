<?php 
require_once 'get_game.php';

$playerID = isset($_POST['player_id']) ? intval($_POST['player_id']) : 0;
playerCheck($game, $playerID);


$dist = isset($_POST['distance']) ? intval($_POST['distance']) : 0; 
$shipID = isset($_POST['ship_id']) ? intval($_POST['ship_id']) : 0; 
$ship = $game->getShipByID($shipID);
echo $ship;
if ($ship) {
	if ($ship->moveShip($dist, $game->getMap())) {
		$game->updateMap();
		saveGame($game, $gameFile);
		header("Content-Type: application/json");
		echo json_encode($game);
		exit();
	}
}
sendError();
?>