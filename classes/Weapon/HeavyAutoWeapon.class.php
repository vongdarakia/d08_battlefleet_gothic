<?php
require_once 'Weapon.class.php';

class HeavyAutoWeapon extends Weapon {
	public static function doc() {
		return file_get_contents('./HeavyAutoWeapon.doc.txt');
	}

	public function __construct( $owner = null, $ship = null ) {
		parent::__construct(array('charge' => 5, 'damage' => 2, 'short' => 3, 'middle' => 7, 'long' => 10, 'owner' => $owner, 'ship' => $ship));
	}
}
?>