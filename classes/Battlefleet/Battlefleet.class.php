<?php 
// require_once('../Weapon/Weapon.class.php');
require_once 'Phase/OrderPhase.class.php';
require_once 'Phase/MovementPhase.class.php';
require_once 'Phase/ShootingPhase.class.php';
require_once 'Player.class.php';
require_once __DIR__ . '/../Spaceship/Spaceship.class.php';

class Battlefleet {
	public static $N = 0;
	public static $E = 1;
	public static $S = 2;
	public static $W = 3;
	public static $verbose = false;

	private $_currentPhase;
	private $_playerTurn;
	private $_players;
	private $_gameSize;

	public function __construct() {
		$this->_currentPhase = 0;
		$this->_playerTurn = 0;
		$this->_gameSize = 500;
		$this->_currentPlayer = new Player("Player 1");
		$this->_players = array();
		$this->_players[] = $this->_currentPlayer;
		$this->_players[] = new Player("Player 2");

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