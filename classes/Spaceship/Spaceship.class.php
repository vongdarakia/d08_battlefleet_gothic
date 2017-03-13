<?php
require_once __DIR__ . '/../Battlefleet/Object.class.php';
require_once __DIR__ . '/../Battlefleet/Battlefleet.class.php';
require_once __DIR__ . '/../Battlefleet/Player.class.php';
require_once __DIR__ . '/../Weapon/Weapon.class.php';

abstract class Spaceship extends Object implements JsonSerializable {
	protected $_length = 1;
	protected $_width = 1;
	protected $_hp = 1; // hull/health points
	protected $_maxhp = 1; // max hp
	protected $_pp = 0; // engine power/power points
	protected $_speed = 1; // maximum speed
	protected $_handle = 0; // minimum speed
	protected $_weapons = array();
	protected $_direction = Battlefleet::E; // 0 1 2 3 -> N E S W
	protected $_cost = 100;
	protected $_name = 'placeholder name';
	protected $_x = 0;
	protected $_y = 0;
	protected $_owner = null;

	protected $_hor = 1;
	protected $_ver = 1;
	protected $_movedDist = 0; 

	protected $_shield = 0; // shield
	protected $_extraSpeed = 0; // extra speed
	protected $_moveDecided = false;
	protected $_turnAllowed = true;
	protected $_stationary = true;

	private static $_idCounter = 1;

	public static function doc() {
		return file_get_contents('./Spaceship.doc.txt');
	}

	public function __construct( array $kwargs ) {
		if (array_key_exists('length', $kwargs)) {
			$this->_length = $kwargs['length'];
			$this->_ver = $this->_length;
		}
		if (array_key_exists('width', $kwargs)) {
			$this->_width = $kwargs['width'];
			$this->_hor = $this->_width;
		}
		if (array_key_exists('hp', $kwargs)) {
			$this->_hp = $kwargs['hp'];
			$this->_maxhp = $this->_hp;
		}
		if (array_key_exists('pp', $kwargs)) {
			$this->_pp = $kwargs['pp'];
		}
		if (array_key_exists('speed', $kwargs)) {
			$this->_speed = $kwargs['speed'];
		}
		if (array_key_exists('handle', $kwargs)) {
			$this->_handle = $kwargs['handle'];
		}
		if (array_key_exists('weapons', $kwargs)) {
			$this->_weapons = $kwargs['weapons'];
		}
		if (array_key_exists('direction', $kwargs)) {
			$this->_direction = $kwargs['direction'];
		}
		if (array_key_exists('cost', $kwargs)) {
			$this->_cost = $kwargs['cost'];
		}
		if (array_key_exists('name', $kwargs)) {
			$this->_name = $kwargs['name'];
		}
		if (array_key_exists('x', $kwargs)) {
			$this->_x = $kwargs['x'];
		}
		if (array_key_exists('y', $kwargs)) {
			$this->_y = $kwargs['y'];
		}
		if (array_key_exists('owner', $kwargs)) {
			$this->_owner = $kwargs['owner'];
		}
		parent::__construct(self::$_idCounter);
		self::$_idCounter++;
	}

	public function __toString() {
		return $this->_name . " ({$this->_x}, {$this->_y})";
	}

	public function getLength() {
		return $this->_length;
	}

	public function getWidth() {
		return $this->_width;
	}

	public function getHP() {
		return $this->_hp;
	}

	public function getWeapons() {
		return $this->_weapons;
	}

	public function getDirection() {
		return $this->_direction;
	}

	public function getX() {
		return $this->_x;
	}

	public function getY() {
		return $this->_y;
	}

	public function getHor() {
		return $this->_hor;
	}

	public function getVer() {
		return $this->_ver;
	}

	public function getOwner() {
		return $this->_owner;
	}

	public function getMovedDist() {
		return $this->_movedDist;
	}

	public function getSpeed() {
		return $this->_speed + $this->_extraSpeed;
	}

	public function isStationary() {
		return $this->_stationary;
	}

	public function setStationary( $status ) {
		if ($status != false && $status != true)
			return false;
		$this->_stationary = $status;
		return true;
	}

	public function setDirection( $direction ) {
		if ($direction >= 0 && $direction <= 3) {
			$this->_direction = $direction;
			return true;
		}
		return false;
	}

	/*public function getXDir() {
		if ($this->_direction == Battlefleet::N || $this->_direction == Battlefleet::E)
			return 1;
		if ($this->_direction == Battlefleet::S || $this->_direction == Battlefleet::W)
			return -1;
		return 0;
	}

	public function getYDir() {
		if ($this->_direction == Battlefleet::N || $this->_direction == Battlefleet::W)
			return 1;
		if ($this->_direction == Battlefleet::S || $this->_direction == Battlefleet::E)
			return -1;
		return 0;
	}

	public function getXEnd() {
		if ($this->_direction == Battlefleet::N || $this->_direction == Battlefleet::E)
			return $this->_x + $this->_width;
		if ($this->_direction == Battlefleet::S || $this->_direction == Battlefleet::W)
			return $this->_x - $this->_width;
		return $this->_x;
	}

	public function getYEnd() {
		if ($this->_direction == Battlefleet::N || $this->_direction == Battlefleet::W)
			return $this->_y + $this->_length;
		if ($this->_direction == Battlefleet::S || $this->_direction == Battlefleet::E)
			return $this->_y - $this->_length;
		return $this->_y;
	}*/

	

	// todo: more get functions

	public function spendPP( $speed, $shield, $weapons, $repair ) {
		$pp = $speed + $shield + $repair;

		foreach ($weapons as $key => $amount) {
			$pp += $amount;
		}
		if ($pp > $this->_pp) { 
			// error
			return false;
		}
		$this->_extraSpeed += Battlefleet::rollDiceSum($speed);
		$this->_shield += $shield;
		foreach ($this->_weapons as $i => $weapon) {
			if (array_key_exists($i, $weapons)) {
				$this->_weapons[$i]->addCharge($weapons[$i]);
			}
		}
		if (Battlefleet::rollDice($repair)[6] > 0) {
			$this->_hp = $this->_maxhp;
		}
		return true;
	}

	public function resetStats() {
		$this->_extraSpeed = 0;
		$this->_shield = 0;
		$this->_movedDist = 0;
		$this->_moveDecided = false;
		if ($this->_stationary == true)
			$this->_turnAllowed = true;
		else
			$this->_turnAllowed = false;
		foreach ($this->_weapons as $i => $weapon) {
			$this->_weapons[$i]->resetCharge();
		}
	}

	public function takeDamage( $d ) {
		if ($d <= $this->_shield) {
			$this->_shield -= $d;
		}
		else {
			$this->_hp += $this->_shield;
			$this->_hp -= $d;
			$this->_shield = 0;
		}
	}

	public function isDead() {
		return $this->_hp <= 0;
	}

	// public function addWeapon($weapon) {
	// 	if ($weapon instanceof Weapon) {
	// 		$this->_weapons[] = $weapon;
	// 	}
	// 	else {
	// 		echo "Not a weapon\n";
	// 	}
	// }

	public function setMoveDecided( $val ) {
		if ($val == 0 || $val == 1) {
			$this->_moveDecided = $val;
			return true;
		}
		return false;
	}

	public function setOwner( $owner ) {
		if ($owner instanceof Player) {
			$this->_owner = $owner;
		}
		else {
			// error
		}
	}

	private function collided ( $map, $orient, $x, $y ) {
		//Setup env
		$direction = $this->_direction;
		$x0 = $this->_x;
		$y0 = $this->_y;
		$hor = ($orient % 2) ? $this->_width : $this->_length;
		$ver = ($orient % 2) ? $this->_length : $this->_width;

		// Checking interval;
		$x0 = $this->_x + (($orient + 1) % 4 == 0) * ($hor - 1);
		$intx = $x + (($orient + 1) % 4 != 0) * ($hor - 1);
		$y0 = $this->_y + (($orient + 1) % 3 != 0) * ($ver - 1);
		$inty = $y + (($orient + 1) % 3 == 0) * ($ver - 1);

		// Set the direction for collision of checking
		$x_sign = ($orient == 3) ? -1 : 1;
		$y_sign = ($orient == 2) ? 1 : -1;

		// Check for collisions
		if ($orient % 2 == 1) {
			// echo "x0: " . $x0 . " | intx: " . $intx . " | sign_x: ". $x_sign . PHP_EOL
			// . "y0: " . $y0 . " | inty: " . $inty . " | sign_y: ". $y_sign. PHP_EOL;
			for ($c = $x0; ($intx - $c) * $x_sign >= 0; $c += $x_sign) {
				$obstacle_hit = 0;
				for ($r = $y0; ($inty - $r) * $y_sign >= 0; $r += $y_sign) {
					// Check map border collisions
					if ($c >= Battlefleet::MAP_WIDTH || $r >= Battlefleet::MAP_LEN || $c < 0 || $r < 0)
						return - 1;
					$map_val = $map[$r][$c];
					// echo "Map val: " . $map_val . PHP_EOL;
					if ($map_val instanceof Spaceship && $map_val !== $this) {
						// echo "HIT!\n";
						$obstacle_hit = 0;
						if ($orient == $this->_direction) {
														
							$x = $c - (($orient == 1) ? $hor :  -1);
							$this->_movedDist += abs($this->_x - $x);
							
							// Check and take damage
							if ($this->_movedDist > $this->_handle) {
								$temp = $this->_hp;
								$this->takeDamage($map_val->getHP());
								$map_val->takeDamage($temp);
							}

							// Stop here
							$this->_x = $x;
						}		

						// Set $map_val and this ship to stationary;
						$this->_stationary = true;
						$map_val->setStationary(True);
						return 1;
					}
					else if ($map_val == "0") {
						$obstacle_hit = 1;
					}
				}
				if ($obstacle_hit == 1)
					return -1;
			}
		}
		else {
			// echo "y0: " . $y0 . " | inty: " . $inty . " | sign_y: ". $y_sign. PHP_EOL
			// . "x0: " . $x0 . " | intx: " . $intx . " | sign_x: ". $x_sign . PHP_EOL;
			for ($r = $y0; ($inty - $r) * $y_sign >= 0; $r += $y_sign) {
				$obstacle_hit = 0;
				for ($c = $x0; ($intx - $c) * $x_sign >= 0; $c += $x_sign) {
					// Check map border collisions
					if ($c >= Battlefleet::MAP_WIDTH || $r >= Battlefleet::MAP_LEN || $c < 0 || $r < 0)
						return - 1;
					$map_val = $map[$r][$c];
					// echo "Map val: " . $map_val . PHP_EOL;
					if ($map_val instanceof Spaceship && $map_val !== $this) {
						// echo "HIT!\n";
						$obstacle_hit = 0;
						if ($orient == $this->_direction) {
														
							$y = $r - (($orient == 2) ? $ver :  -1);
							$this->_movedDist += abs($this->_y - $y);
							
							// Check and take damage
							if ($this->_movedDist > $this->_handle) {
								$temp = $this->_hp;
								$this->takeDamage($map_val->getHP());
								$map_val->takeDamage($temp);
							}

							// Stop here
							$this->_y = $y;
						}		

						// Set $map_val and this ship to stationary;
						$this->_stationary = true;
						$map_val->setStationary(True);
						return 1;
					}
					else if ($map_val == "0") {
						$obstacle_hit = 1;
					}
				}
				if ($obstacle_hit == 1)
					return -1;
			}
		}

		// Still flying =)
		return 0;
	}

	public function turnShip( $rot, $map ) {
		if ($rot == 0)
			return true;
		if (($rot != 1 && $rot != -1) || $this->_moveDecided || !($this->_turnAllowed))
			return false;

		$orient = $this->_direction;
		if ($rot < 0) {
			$orient = ($this->_direction + 3) % 4;
		}
		else if ($rot > 0) {
			$orient = ($this->_direction + 1) % 4;
		}

		// Rotation around top left point (not around the center)
		$x = $this->_x;
		$y = $this->_y;

		$collided = $this->collided( $map, $orient, $x, $y );

		if ($collided == 0) {
			// Change ship attributes
			$this->_x = $x;
			$this->_y = $y;
			$this->_direction = $orient;
			$this->_hor = ($this->_direction % 2) ? $this->_width : $this->_length;
			$this->_ver = ($this->_direction % 2) ? $this->_length : $this->_width;
		}
		else if ($collided == -1) {
			// Ship destroyed
			$this->_hp = -1;
		}
		else {
			$this->_moveDecided = true;
		}
		$this->_turnAllowed = false;
		return true;
	}

	public function moveShip( $d, $map ) {
		if ((!$this->_stationary && $this->_movedDist + $d < $this->_handle) 
			|| $this->_movedDist + $d > $this->_speed + $this->_extraSpeed
			|| $this->_moveDecided) {
			return false;
		}
		else if ($this->_stationary && $d == 0)
			return true;
		$x = $this->_x + $d * ((2 - $this->_direction) % 2);
		$y = $this->_y + $d * (($this->_direction - 1) % 2);

		$collided = $this->collided( $map, $this->_direction, $x, $y);

		if ($collided == 0) {
			// Change ship attributes
			$this->_x = $x;
			$this->_y = $y;
			$this->_movedDist += $d;
			if ($d >= $this->_handle)
				$this->_turnAllowed = true;
			if ($this->_movedDist != $this->_handle)
				$this->_stationary = false;
			else
				$this->_stationary = true;
		}
		else if ($collided == -1) {
			// Ship destroyed
			$this->_hp = -1;
		}
		// In case of collided == 1 ship attributes are set within collided function
		return true;
	}

	public function setMoved( $val ) {
		$this->_moved = $val;
	}

	public function display() {
		echo $this->_name . PHP_EOL;
		echo "\tid: " . $this->_id;
		echo "\n\tx: " . $this->_x;
		echo "\n\ty: " . $this->_y;
		echo "\n\tdir: " . $this->_direction;
		echo "\n\tcost: " . $this->_cost;
		echo "\n\tlength: " . $this->_length;
		echo "\n\twidth: " . $this->_width;
		echo "\n\thorizontal: " . $this->_hor;
		echo "\n\tvertical: " . $this->_ver;
		echo "\n\thull: " . $this->_hp;
		echo "\n\tspeed: " . $this->_speed;
		echo "\n\thandle: " . $this->_handle;
		echo "\n\textra speed: " . $this->_extraSpeed;
		echo "\n\tshield: " . $this->_shield;
		echo "\n\nWeapons: of " . $this->_name . PHP_EOL;

		foreach ($this->_weapons as $key => $weapon) {
			echo PHP_EOL;
			$weapon->display();
			echo PHP_EOL;
		}
	}

	public function getWeaponByID($weaponID) {
		foreach ($this->_weapons as $weapon) {
			if ($weapon->getID() == $weaponID)
				return $weapon;
		}
		return null;
	}

	public function getData() {
		print_r($this);
	}

	public function jsonSerialize() {
        return (object)array(
        	"_id" 		=> $this->_id,
        	"length" 	=> $this->_length,
			"width" 	=> $this->_width,
			"hp" 		=> $this->_hp,
			"maxhp" 	=> $this->_maxhp,
			"pp"		=> $this->_pp,
			"speed" 	=> $this->_speed,
			"handle" 	=> $this->_handle,
			"weapons"	=> $this->_weapons,
			"direction"	=> $this->_direction,
			"cost" 		=> $this->_cost,
			"name" 		=> $this->_name,
			"x" 		=> $this->_x,
			"y" 		=> $this->_y,
			"hor" 		=> $this->_hor,
			"ver"		=> $this->_ver,
			"shield" 	=> $this->_shield,
			"extraSpeed" => $this->_extraSpeed,
			"maxSpeed" 	=> ($this->_extraSpeed + $this->_speed),
			"minSpeed" 	=> ($this->_stationary ? 0 : $this->_handle)
        );
    }
}
?>