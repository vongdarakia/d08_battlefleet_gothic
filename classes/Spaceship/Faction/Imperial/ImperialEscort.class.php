<?php
require_once 'Imperial.class.php';
require_once __DIR__ . '/../../../Weapon/NauticalLance.class.php';

class ImperialEscort extends Imperial {
	public static function doc() {
		return file_get_contents('./ImperialEscort.doc.txt');
	}

	public function __construct( $x = 0, $y = 0, $owner = null, $name = 'Sword Frigate' ) {
		parent::__construct(array('length' => 1, 'width' => 4, 'hp' => 5, 'pp' => 10, 'speed' => 15, 'handle' => 4, 'weapons' => array(new NauticalLance()), 'cost' => 100, 'name' => $name, 'x' => $x, 'y' => $y, 'owner' => $owner));
	}
}
?>