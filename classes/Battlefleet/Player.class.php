<?php 

class Player {
	private $_ships;

	public function __construct() {
		$this->_ships = array();

		if (Battlefleet::$verbose)
			print("Player constructed.\n");
	}

	public function __destruct() {
		if (Battlefleet::$verbose)
			print("Player destroyed.\n");
	}

	public function addShip( $ship ) {
		if ($ship instanceof Spaceship) {
			$this->_ships[] = $ship;
		}
		else {
			echo "Can't add this object to players ships.";
		}
	}

	
}

?>