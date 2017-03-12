<?php 

error_reporting(E_ALL);
ini_set('display_errors', 1);

date_default_timezone_set('America/Los_Angeles');
require_once './actions/game_save.php';
require_once './classes/Battlefleet/Battlefleet.class.php';
require_once './classes/Spaceship/Faction/Imperial/ImperialFrigate.class.php';
require_once './classes/Weapon/NauticalLance.class.php';

Battlefleet::$verbose = true;

$bf = new Battlefleet();
$ship = new ImperialFrigate(0, 10);
$ship2 = new ImperialFrigate(10, 10);
// $ship->addWeapon(new NauticalLance());
// $id = 0;
// $id++;
// echo $id;
// $ship->moveShip(4, $bf->getMap()); 

$bf->getCurrentPlayer()->addShip($ship);
$bf->getCurrentPlayer()->addShip($ship2);
$bf->updateMap();

$ship->getWeapons()[0]->addCharge(20);
$ship->getWeapons()[0]->shoot($ship, $bf->getMap());
echo $ship->getHP() . '  ' . $ship2->getHP() . PHP_EOL;
// $bf->updateShips();
$bf->updateMap();

saveGame($bf, './private/game');

$bf->startPhase();
$ship2->display();
echo "1\n";
while (true) {
	if (!(selectPhaseOption1($bf)))
		$bf->nextPhase() ;
}

function selectPhaseOption1( $bf ) {
	$option = readline("Phase 1 (order)\n"
		. "\t[1] Select Ship\n"
		. "\t[2] Damage Ship\n"
		. "\t[m] Display Map\n"
		. "\t[0] End Turn\n"
		. $bf->getCurrentPlayer() . ": "
	);

	if ($option == "1") {
		echo PHP_EOL;
		selectShip($bf->getCurrentPlayer(), $bf->getCurrentPhase(), $bf);
	}

	if ($option == "2") {
		echo PHP_EOL;
		echo "Ship took 2 damage\n";
		$ship = $bf->getCurrentPlayer()->getShips()[0];
		$ship->takeDamage(2);
		$ship->display();
	}

	if ($option == "m") {
		echo PHP_EOL;
		$bf->updateMap();
		$bf->displayMap();
	}

	if ($option == "0")
		return 0;
	return 1;
}

function selectShip( $player, $phase, $bf ) {
	$ships = $player->getShips();
	if (count($ships) > 0) {
		echo "Select ship:\n";
		foreach ($player->getShips() as $key => $ship) {
			echo "\t[{$key}] {$ship}\n";
		}
		echo PHP_EOL;

		$option = readline($player . ": ");
		if (array_key_exists($option, $ships)) {
			if ($phase == 0)
				selectPPOption($option, $ships[$option], $player);
			else if ($phase == 1)
				selectMove($option, $ships[$option], $bf);
		}
		else {
			echo "Invalid option" . PHP_EOL;
		}
		// if ($option == "1") {
		// 	echo PHP_EOL;
			
		// }
	}
	else {
		echo "You have no ships\n\n";
	}
}

function selectMove( $shipIdx, $ship, $bf) {
	while (True) {
		$option = readline("Select Move\n"
			. "\t[1] Turn Ship\n"
			. "\t[2] Move Ship\n"
			. "\t[m] Display Map\n"
			. "\t[0] End Turn\n"
			. $bf->getCurrentPlayer() . ": "
		);

		if ($option == "1") {
			echo PHP_EOL;
			$dir = readline("Select direction (1 or -1)\n"
				. $bf->getCurrentPlayer() . ": "
			);
			if ($dir == "1" || $dir == "-1")
				$ship->turnShip($dir);
			else
				echo "Error: direction must be 1 or -1\n";
		}

		else if ($option == "2" ) {
			echo PHP_EOL;
			$dist = intval(readline("Select distance\n"
				. $bf->getCurrentPlayer() . ": "
			));
			echo $dist . " selected" . PHP_EOL;
			$ship->moveShip($dist, $bf->getMap());
		}

		else if ($option == "m") {
			echo PHP_EOL;
			$bf->updateMap();
			$bf->displayMap();
		}

		else
			break ;
	}
}


function selectPPOption($shipIdx, $ship, $player) {
	echo "\nYou've selected " . $ship . PHP_EOL . PHP_EOL;
	echo "What do you want to do?\n";
	echo "\t[0] Increase speed\n";
	echo "\t[1] Increase shield power\n";
	echo "\t[2] Increase weapon charges\n";
	echo "\t[3] Repair ship (must be stationary)\n\n";
	$option = readline($player . ": ");
	promptPPSpendings($shipIdx, $ship, $option, $player);
}

function promptPPSpendings($shipIdx, $ship, $option, $player) {
	// echo "\nHow much PP do you want to spend? ";
	$pp = readline("\nHow much PP do you want to spend? ");
	$pp = intval($pp);
	

	if ($option == "0") {
		echo "\nYou've spent " . $pp . " on more speed for your " . $ship . PHP_EOL . PHP_EOL;
		$ship->spendPP( $pp, 0, [], 0 );
	}
	else if ($option == "1") {
		echo "\nYou've spent " . $pp . " on more shield for your " . $ship . PHP_EOL . PHP_EOL;
		$ship->spendPP( 0, $pp, [], 0 );
	}
	else if ($option == "2") {
		$weapons = [0, 0];
		$weapons[$shipIdx] = $pp;
		echo "\nYou've spent " . $pp . " on more weapon charges for your " . $ship . PHP_EOL . PHP_EOL;
		$ship->spendPP( 0, 0, [$pp], 0 );
	}
	else if ($option == "3") {
		echo "\nYou've spent " . $pp . " on repairing your " . $ship . PHP_EOL . PHP_EOL;
		$ship->spendPP( 0, 0, [], $pp );
	}

	$ship->display();
	echo PHP_EOL;
}



function generateMap($width, $length) {

}

?>
