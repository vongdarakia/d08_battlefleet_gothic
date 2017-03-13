<?php
require_once __DIR__ . '/../../Spaceship.class.php';
require_once __DIR__ . '/../../../Weapon/MacroCanon.class.php';

class Ork extends Spaceship {
	public static function doc() {
		return file_get_contents('./Ork.doc.txt');
	}

	// the purpose of this constructor is to change some default values for each faction
	// Ex: all ork spaceships have a macro canon
	// so a macro canon gets appended to the list of weapons
	public function __construct( array $kwargs ) {
		if (array_key_exists('weapons', $kwargs)) {
			$kwargs['weapons'][] = new MacroCanon($this);
		}
		else {
			$kwargs['weapons'] = array(new MacroCanon($this));
		}
		parent::__construct($kwargs);
	}
}
?>