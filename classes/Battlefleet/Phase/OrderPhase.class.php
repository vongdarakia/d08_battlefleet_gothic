<?php 
require_once("Phase.class.php");

class OrderPhase {
	public static function startPhase() {
		if (Battlefleet::$verbose)
			print("Order phase started.\n");
	}

	public static function rollForMoreSpeed( $game, $numPP, $ship ) {
		// if ($numPP)
		// $rolledVal = Battlefleet::rollDiceSum($numPP, 6);

	}

	public static function rollForMoreFire( $game, $ship ) {

	}

	public static function rollForRepair( $game, $ship ) {

	}
}

?>