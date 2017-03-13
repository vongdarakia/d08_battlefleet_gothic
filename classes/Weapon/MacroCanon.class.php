<?php
require_once 'Weapon.class.php';

class MacroCanon extends Weapon {
	public static function doc() {
		return file_get_contents('./MacroCanon.doc.txt');
	}

	public function __construct( $ship = null, $owner = null ) {
		parent::__construct(array('charge' => 0, 'damage' => 1, 'short' => 10, 'middle' => 20, 'long' => 30, 'owner' => $owner, 'ship' => $ship));
	}

	public function shoot( $map ) {
		$hit = parent::shoot($map);
 		if ($hit === null) {
 			return $hit;
 		}
 		$ships = array();
 		for ($i = -9; $i <= 9; $i++) {
 			for ($j = -9; $j <= 9; $j++) {
 				if ($i * $i + $j * $j <= 81) {
 					$r = $i + hit[0];
 					$c = $j + hit[1];
 					if (Battlefleet::inMap($r, $c) && $map[$r][$c] !== null && !in_array($map[$r][$c], $ships)) {
 						$ships[] = $map[$r][$c];
 					}
 				}
 			}
 		}
 		foreach ($ships as $ship) {
 			$ship->takeDamage(rand(1, 6)); // random dice roll
 		}
	}
}
?>