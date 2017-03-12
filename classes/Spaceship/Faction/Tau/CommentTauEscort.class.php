<?php
require_once 'Tau.class.php';
require_once __DIR__ . '/../../../Weapon/RailgunLight.class.php';

class TauEscort extends Tau {
	public static function doc() {
		return file_get_contents('./TauEscort.doc.txt');
	}

	public function __construct( $x = 0, $y = 0, $owner = null, $name = 'Kir shasvre' ) {
		parent::__construct(array('length' => 1, 'width' => 3, 'hp' => 4, 'pp' => 10, 'speed' => 18, 'handle' => 3, 'weapons' => array(new RailgunLight()), 'cost' => 100, 'name' => $name, 'x' => $x, 'y' => $y, 'owner' => $owner));
	}
}
?>