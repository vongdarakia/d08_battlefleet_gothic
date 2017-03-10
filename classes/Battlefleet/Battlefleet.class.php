<?php 
// require_once('../Weapon/Weapon.class.php');
require_once('Phase/OrderPhase.class.php');
require_once('Phase/MovementPhase.class.php');
require_once('Phase/ShootingPhase.class.php');

class Battlefleet {
	public static $N = 0;
	public static $E = 1;
	public static $S = 2;
	public static $W = 3;
	public static $verbose = false;

	private $_currentPhase;
	private $_playerTurn;
	private $_gameSize;

	public function __construct() {
		$this->_currentPhase = 0;
		$this->_playerTurn = 0;
		$this->_gameSize = 500;

		if (self::$verbose)
			print($this . " constructed.\n");
	}

	public function __toString() {
		return "Battlefleet";
	}

	public function startPhase() {
		if (self::$verbose)
			print("Starting current phase.\n");
		switch ($_currentPhase) {
			case 0:
				
				break;
			case 1:
				MovementPhase::startPhase();
				break;
			case 2:
				ShootingPhase::startPhase();
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

	public static rollDice( $numDice, $sides=6 ) {
		$diceRolled = array();

		for ($i=0; $i < $numDice; $i++) {
			$diceRolled[] = rand(1, $sides);
		}

		return $diceRolled;
	}

	public static rollDiceSum( $numDice, $sides=6 ) {
		$val = 0;
		for ($i=0; $i < $numDice; $i++) {
			$val += rand(1, $sides);
		}
		return $val;
	}

	public static sumDiceRolled( $diceRolled ) {
		$val = 0;
		$len = count($diceRolled);

		for ($i=0; $i < $len; $i++) {
			$val += $diceRolled[$i];
		}
		return $val;
	}
}

?>