<?php 

require_once __DIR__ . '/../Spaceship/Spaceship.class.php';

class Player {
	private $_ships;
	private $_playerName;

	public function __construct( $playerName ) {
		$this->_ships = array();
		$this->_playerName = $playerName;

		if (Battlefleet::$verbose)
			print("Player constructed.\n");
	}

	public function __toString() {
		return $this->_playerName;
	}

	public function __destruct() {
		if (Battlefleet::$verbose)
			print($this->_playerName . " destroyed.\n");
	}

	public function addShip( $ship ) {
		if ($ship instanceof Spaceship) {
			$this->_ships[] = $ship;
		}
		else {
			echo "Can't add this object to players ships.";
		}
	}

	public function getShips() {
		return $this->_ships;
	}
}

?>