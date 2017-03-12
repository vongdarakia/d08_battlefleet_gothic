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
		$coords = parent::shoot($map);
		// handle explosion
	}
}
?>