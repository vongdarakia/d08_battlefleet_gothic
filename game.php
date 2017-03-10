<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

date_default_timezone_set('America/Los_Angeles');
require_once('./classes/Battlefleet/Battlefleet.class.php');
require_once './classes/Spaceship/Faction/Imperial/ImperialFrigate.class.php';

Battlefleet::$verbose = true;

$bf = new Battlefleet();
$bf->getCurrentPlayer()->addShip(new ImperialFrigate(0, 0));

$bf->startPhase();

while (true) {
	selectPhaseOption1($bf);
}

function selectPhaseOption1($bf) {
	$option = readline("Phase 1 (order)\n"
		. "\t[1] Select Ship\n"
		. "\t[m] Display Map\n"
		. "\t[0] End Turn\n"
		. $bf->getCurrentPlayer() . ": "
	);

	if ($option == "1") {
		echo PHP_EOL;
		selectShip($bf->getCurrentPlayer());
	}

	if ($option == "m") {
		echo PHP_EOL;
		$bf->updateMap();
		$bf->displayMap();
	}
}

function selectShip($player) {
	$ships = $player->getShips();
	if (count($ships) > 0) {
		echo "Select ship:\n";
		foreach ($player->getShips() as $key => $ship) {
			echo "\t[{$key}] {$ship}\n";
		}
		echo "\t[{$key}] {$ship}\n";

		$option = readline($bf->getCurrentPlayer() . ": ");
		if ($option == "1") {
			echo PHP_EOL;
			selectShip($bf->getCurrentPlayer());
		}
	}
	else {
		echo "You have no ships\n\n";
	}
}

function generateMap($width, $length) {

}

?>