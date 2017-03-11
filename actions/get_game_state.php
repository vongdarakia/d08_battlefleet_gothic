<?php 
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	date_default_timezone_set('America/Los_Angeles');
	require_once __DIR__ . '/../classes/Battlefleet/Battlefleet.class.php';
	require_once __DIR__ . '/../classes/Battlefleet/Object.class.php';
	require_once __DIR__ . '/../classes/Battlefleet/Player.class.php';
	require_once __DIR__ . '/../classes/Spaceship/Spaceship.class.php';
	require_once __DIR__ . '/../classes/Spaceship/Faction/Imperial/ImperialFrigate.class.php';
	// require_once __DIR__ . '/../classes/Spaceship/Faction/Imperial/ImperialFrigate.class.php';
	require_once __DIR__ . '/../classes/Weapon/NauticalLance.class.php';
	require_once __DIR__ . '/../classes/Weapon/Weapon.class.php';
	$bf = new Battlefleet();
	// $ship = new ImperialFrigate($bf->getPlayers()[0], 0, 0);
	// $ship2 = new ImperialFrigate($bf->getPlayers()[1], 145, 99);
	// $bf->getPlayers()[0]->addShip($ship);
	// $bf->getPlayers()[1]->addShip($ship2);
	// $bf->updateMap();
	// echo "huh";
	// print_r($bf);
	require_once 'get_game.php';
	// require_once 'game_save.php';
	// saveGame($bf, '../private/game');
	// echo "done";
	// $game = loadGame($gameFile);

	// require_once 'get_game.php';

	// $bf =loadGame($gameFile);
	// print ($bf);
	// $bf->displayMap();
	// header("Content-Type: application/json");
	echo json_encode($game);
	// echo $bf;
	// echo "done";

?>