<?php
require_once 'Ork.class.php';
require_once __DIR__ . '/../../../Weapon/SideLaserBatteries.class.php';

class Onslaught extends Ork {
	public static function doc() {
		return file_get_contents('./Onslaught.doc.txt');
	}

	public function __construct( $x = 0, $y = 0, $owner = null, $name = 'Orktobre Roug' ) {
		parent::__construct(array('length' => 1, 'width' => 2, 'hp' => 4, 'pp' => 10, 'speed' => 19, 'handle' => 3, 'weapons' => array(new SideLaserBatteries()), 'cost' => 100, 'name' => $name, 'x' => $x, 'y' => $y, 'owner' => $owner));
	}
}
?>