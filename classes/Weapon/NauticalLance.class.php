<?php
require_once 'Weapon.class.php';

class NauticalLance extends Weapon {
	public static function doc() {
		return file_get_contents('./NauticalLance.doc.txt');
	}

	public function __construct( $ship = null, $owner = null ) {
		// All parameters are written explicitly even though those are the default values, so they aren't necessary.
		// This is just a reference for other weapons.
		parent::__construct(array('charge' => 0, 'damage' => 1, 'short' => 30, 'middle' => 60, 'long' => 90, 'owner' => $owner, 'ship' => $ship));
	}
}
?>