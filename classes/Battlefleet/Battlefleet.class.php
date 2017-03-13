<?php 
// require_once('../Weapon/Weapon.class.php');
require_once 'Phase/OrderPhase.class.php';
require_once 'Phase/MovementPhase.class.php';
require_once 'Phase/ShootingPhase.class.php';
require_once 'Player.class.php';
require_once __DIR__ . '/../Spaceship/Spaceship.class.php';

class Battlefleet implements JsonSerializable {
	const N = 0;
	const E = 1;
	const S = 2;
	const W = 3;
	const MAP_LEN = 100;
	const MAP_WIDTH = 150;
	public static $verbose = false;

	private $_currentPhase;
	private $_gameTurn;
	private $_players;
	private $_gameSize;
	private $_map;
	private $_currentPlayer;
	private $_isPlaying;
	private $_obstacles = array();

	private function setObstacles() {
		for ($ob_num=0; $ob_num < 10; $ob_num++) {
			
			$x = rand(15, Battlefleet::MAP_WIDTH - 20);
			$y = rand(15, Battlefleet::MAP_LEN - 20);
			$hor = rand(2,5);
			$ver = rand(2,5);
			for ($i=0; $i < $ver; $i++) {
				for ($j=0; $j < $hor; $j++)
					$this->_obstacles[] = array($y + $j, $x + $i); 
			}
			
		}
	}

	public function __construct() {
		$this->_currentPhase = 0;
		$this->_gameTurn = 0;
		$this->_gameSize = 500;

		$this->_players = array();
		$this->_players[] = new Player("Player 1");
		$this->_players[] = new Player("Player 2");

		$ship = new ImperialFrigate(0, 0);
		$ship->setDirection(Battlefleet::E);
		$ship2 = new ImperialFrigate(146, 99);
		$ship2->setDirection(Battlefleet::W);

		$this->_players[0]->addShip($ship);
		$this->_players[1]->addShip($ship2);
		$this->_currentPlayer = $this->_players[0];
		$this->_isPlaying = true;

		$this->_map = array();
		
		for ($i=0; $i < Battlefleet::MAP_LEN; $i++) {
			$cols = array();
			for ($j=0; $j < Battlefleet::MAP_WIDTH; $j++) { 
				$cols[] = null;
			}
			$this->_map[] = $cols;
		}
		$this->setObstacles(); 
		$this->updateMap();

		if (self::$verbose)
			print($this . " constructed.\n");
	}

	public function __toString() {
		return "Battlefleet";
	}

	// public function startPhase() {
	// 	if (self::$verbose)
	// 		print("Starting current phase.\n");
	// 	switch ($this->_currentPhase) {
	// 		case 0:
	// 			if (Battlefleet::$verbose)
	// 				print("Order phase started.\n");
	// 			// Reset everything.
	// 			break;
	// 		case 1:
	// 			if (Battlefleet::$verbose)
	// 				print("Movement phase started.\n");

	// 			break;
	// 		case 2:
	// 			if (Battlefleet::$verbose)
	// 				print("Shooting phase started.\n");
	// 			break;
	// 		default:
	// 			echo "End Game" . PHP_EOL;
	// 	}
	// }

	public function nextPhase() {
		$this->_currentPhase = ($this->_currentPhase + 1) % 3;

		// Reset all ships if starting first phase.
		if ($this->_currentPhase == 0) {
			$ships = $this->getAllShips();
			foreach ($ships as $key => $ship) {
				$ship->resetStats();
			}
		}

		else if ($this->_currentPhase == 2) {
			$ships = $this->getAllShips();

			foreach ($ships as $ship) {
				if ($ship->isStationary())
					continue ;
				$diff = $ship->getHandle() - $ship->getMovedDist();
				if ($diff > 0)
					$ship->moveShip( $ship->getHandle(), $this->getMap() );
			}

			foreach ($ships as $ship) {
				if (!$ship->isDead()) {
					$ship->getWeapons()[0]->shoot($this->getMap());
					$this->updateMap();
				}
			}
			$this->updateShips();
			$this->updateMap();
			$this->_currentPhase = 0;
		}
	}

	public function endTurn() {
		$this->_gameTurn++;

		$this->_currentPlayer = $this->_players[$this->_gameTurn % count($this->_players)];
		if ($this->_gameTurn % count($this->_players) == 0) {
			$this->nextPhase();
		}
	}

	public function getCurrentPhase() {
		return $this->_currentPhase;
	}

	public function getCurrentPlayer() {
		return $this->_currentPlayer;
	}

	public function getAllShips() {
		$ships = array();

		foreach ($this->_players as $player) {
			$pShips = $player->getShips();
			foreach ($pShips as $ship) {
				$ships[] = $ship;
			}
		}

		return $ships;
	}

	public function updateShips() {
		foreach ($this->_players as $player) {
			$pShips = $player->getShips();
			foreach ($pShips as $key => $ship) {
				if ($ship->isDead()) {
					$player->removeShip($key);
				}
			}
		}
		$this->updateMap();
	}

	public function clearMap() {
		for ($i=0; $i < Battlefleet::MAP_LEN; $i++) {
			for ($j=0; $j < Battlefleet::MAP_WIDTH; $j++) { 
				$this->_map[$i][$j] = null;
			}
		}
	}

	public function updateMap() {
		$this->clearMap();

		foreach ($this->_players as $player_key => $player) {
			$ships = $player->getShips();
			
			foreach ($ships as $key => $ship) {
				if ($ship->isDead()) {
					continue;
				}
				$hor = $ship->getHor();
				$ver = $ship->getVer();
				$x = $ship->getX();
				$y = $ship->getY();
				foreach ($this->_obstacles as $obst) {
					$this->_map[$obst[0]][$obst[1]] = "x";
				}

				for ($r = 0; $r < $ver; $r++) { 
					for ($c = 0; $c < $hor; $c++) { 
						$this->_map[$y + $r][$x + $c] = $ship;
					}
				}
			}
		}
	}

	public function getMap() {
		return $this->_map;
	}



	public function displayMap() {
		for ($i=0; $i < Battlefleet::MAP_LEN; $i++) {
			printf("%3d ", $i);
			for ($j=0; $j < Battlefleet::MAP_WIDTH; $j++) { 
				if ($this->_map[$i][$j] === null)
					echo ".";
				else if ($this->_map[$i][$j] === "x")
					echo "x";
				else if ($this->_map[$i][$j]->getOwner() === null)
					echo " ";
				else
					echo $this->_map[$i][$j]->getID();
			}
			echo PHP_EOL;
		}
	}

	public function getShipByID( $shipID ) {
		$ships = $this->getAllShips();
		foreach ($ships as $ship) {
			if ($ship->getID() == $shipID)
				return $ship;
		}
		return null;
	}

	public function getPlayerByID( $playerID ) {
		foreach ($this->_players as $player) {
			if ($player->getID() == $playerID)
				return $player;
		}
		return null;
	}

	public function getPlayers() {
		return $this->_players;
	}

	public function isPlayerTurn( $playerID ) {
		$player = $this->getPlayerByID($playerID);
		return ($player && $this->_currentPlayer->getName() == $player->getName());
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

	public static function inMap( $r, $c ) {
 		return $r >= 0 && $r < Battlefleet::MAP_LEN && $c >= 0 && $c < Battlefleet::MAP_WIDTH;
 	}

	public function jsonSerialize() {
        return (object)array(
        	"currentPhase" => $this->_currentPhase,
			"gameTurn" => $this->_gameTurn,
			"players" => $this->_players,
			"gameSize" => $this->_gameSize,
			"map" => $this->_map,
			"currentPlayer" => $this->_currentPlayer
        );
    }
}

?>