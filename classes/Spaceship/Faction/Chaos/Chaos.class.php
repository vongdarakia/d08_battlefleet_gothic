<?php
require_once '../../Spaceship.class.php';

class Chaos extends Spaceship {
	public static function doc() {
		return file_get_contents('./Chaos.doc.txt');
	}
}
?>