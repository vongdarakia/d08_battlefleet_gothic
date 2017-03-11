<?php 
// require_once('../Weapon/Weapon.class.php');
require_once 'Phase/OrderPhase.class.php';
require_once 'Phase/MovementPhase.class.php';
require_once 'Phase/ShootingPhase.class.php';
require_once 'Player.class.php';
require_once __DIR__ . '/../Spaceship/Spaceship.class.php';

class Battlefleet {
	const N = 0;
	const E = 1;
	const S = 2;
	const W = 3;
	const MAP_LEN = 100;
	const MAP_WIDTH = 150;
	public static $verbose = false;

	private $_currentPhase;
	private $_playerTurn;
	private $_players;
	private $_gameSize;
	private $_map;

	public function __construct() {
		$this->_currentPhase = 0;
		$this->_playerTurn = 0;
		$this->_gameSize = 500;
		$this->_currentPlayer = new Player("Player 1");
		$this->_players = array();
		$this->_players[] = $this->_currentPlayer;
		$this->_players[] = new Player("Player 2");
		$this->_map = array();

		for ($i=0; $i < Battlefleet::MAP_LEN; $i++) {
			$cols = array();
			for ($j=0; $j < Battlefleet::MAP_WIDTH; $j++) { 
				$cols[] = ".";
			}
			$this->_map[] = $cols;
		}

		if (self::$verbose)
			print($this . " constructed.\n");
	}

	public function __toString() {
		return "Battlefleet";
	}

	public function startPhase() {
		if (self::$verbose)
			print("Starting current phase.\n");
		switch ($this->_currentPhase) {
			case 0:
				if (Battlefleet::$verbose)
					print("Order phase started.\n");
				break;
			case 1:
				if (Battlefleet::$verbose)
					print("Movement phase started.\n");
				break;
			case 2:
				if (Battlefleet::$verbose)
					print("Shooting phase started.\n");
				break;
			default:
				echo "End Game" . PHP_EOL;
		}
	}

	public function nextPhase() {
		$this->_currentPhase = ($this->_currentPhase + 1) % 3;
	}

	public function startGame() {

	}

	public function getCurrentPlayer() {
		return $this->_currentPlayer;
	}

	public function getAllShips() {
		$ships = array();

		foreach ($this->_players as $player_key => $player) {
			$pShips = $player->getShips();
			foreach ($pShips as $key => $ship) {
				$ships[] = $ship;
			}
		}

		return $ships;
	}

	public function clearMap() {
		for ($i=0; $i < Battlefleet::MAP_LEN; $i++) {
			for ($j=0; $j < Battlefleet::MAP_WIDTH; $j++) { 
				$cols[$i][$j] = ".";
			}
		}
	}

	public function updateMap() {
		$this->clearMap();

		foreach ($this->_players as $player_key => $player) {
			$ships = $player->getShips();
			echo "ships: " . count($ships) . " \n";
			foreach ($ships as $key => $ship) {
				$x1 = $ship->getXEnd();
				$y1 = $ship->getYEnd();
				echo "ships: {$ship->getX()}, {$ship->getY()} => {$x1}, {$y1} : " . count($ships) . " \n";
				for ($r=$ship->getY(); $r != $y1; $r += $ship->getYDir()) { 
					for ($c=$ship->getX(); $c != $x1; $c += $ship->getXDir()) { 
						$this->_map[$r][$c] = "x";
					}
				}
			}
		}
	}

	public function displayMap() {
		for ($i=0; $i < Battlefleet::MAP_LEN; $i++) {
			printf("%3d ", $i);
			for ($j=0; $j < Battlefleet::MAP_WIDTH; $j++) { 
				echo $this->_map[$i][$j];
			}
			echo PHP_EOL;
		}
	}

	public static function rollDice( $numDice, $sides=6 ) {
		$diceRolled = array_fill(1, $sides, 0);
		for ($i=0; $i < $numDice; $i++) {
			$diceRolled[rand(1, $sides)]++;
		}
		return $diceRolled;
	}

	public static function rollDiceSum( $numDice, $sides=6 ) {
		$val = 0;
		for ($i=0; $i < $numDice; $i++) {
			$val += rand(1, $sides);
		}
		return $val;
	}

	public static function sumDiceRolled( $diceRolled ) {
		$val = 0;

		foreach ($diceRolled as $num => $count) {
			$val += $num * $count;
		}
		return $val;
	}
}

?>