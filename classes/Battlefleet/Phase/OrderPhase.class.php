<?php 
require_once("Phase.class.php");

class OrderPhase extends Phase {
	function startPhase() {
		if (Battlefleet::$verbose)
			print("Order phase started.\n");
	}

	function rollForMoreSpeed( $game, $numPP, $ship ) {
		// if ($numPP)
		// $rolledVal = Battlefleet::rollDiceSum($numPP, 6);

	}

	function rollForMoreFire( $game, $ship ) {

	}

	function rollForRepair( $game, $ship ) {

	}
}

?>