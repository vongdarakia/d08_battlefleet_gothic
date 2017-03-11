<?php 

require_once 'Object.class.php';
require_once __DIR__ . '/../Spaceship/Spaceship.class.php';

class Player extends Object implements JsonSerializable {
	private $_ships;
	private $_playerName;

	private static $_idCounter = 0;

	public function __construct( $playerName ) {
		$this->_ships = array();
		$this->_playerName = $playerName;

		parent::__construct(self::$_idCounter);
		self::$_idCounter++;

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
			$ship->setOwner($this);
		}
		else {
			echo "Can't add this object to players ships.";
		}
	}

	public function removeShip( $ship ) {
		foreach ($this->_ships as $key => $val ) {
			if ($val === $ship) {
				unset($this->_ships[$key]);
			}
		}
	}

	public function getShips() {
		return $this->_ships;
	}

	public function jsonSerialize() {
        return (object)array(
        	"_id" => $this->_id,
        	"ships" => $this->_ships,
			"playerName" => $this->_playerName
        );
    }
}

?>