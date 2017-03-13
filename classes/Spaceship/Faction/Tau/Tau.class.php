<?php
require_once __DIR__ . '/../../Spaceship.class.php';

class Orc extends Spaceship {
	public static function doc() {
		return file_get_contents('./Orc.doc.txt');
	}
}
?>