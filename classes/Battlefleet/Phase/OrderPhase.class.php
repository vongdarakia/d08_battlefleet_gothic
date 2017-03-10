<?php 
require_once("Phase.class.php");

class OrderPhase extends Phase {
	function startPhase() {
		if (Battlefleet::$verbose)
			print("Order phase started.\n");
	}

	function rollForMoreSpeed( $game, $ship ) {
		$rolledVal = Battlefleet::rollDiceSum(1, 6);
	}

	function rollForMoreFire( $game, $ship ) {

	}

	function roolForRepair( $game, $ship ) {

	}
}

?>