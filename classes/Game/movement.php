<?php
require_once 'Spaceship.class.php'

public function check_validity ( $map, $ship, $x, $y, $orient ) {

	//Setup env
	$obstacles = $map->obstacles;
	$ships = $map->ships;
	$width = $ship->width;
	$length = $ship->length;
	$direction = $ship->direction;
	$x0 = $ship->x;
	$y0 = $ship->y;
	$xmax = $map->xmax;
	$ymax = $max->ymax;

	// Checking interval;
	if ($orient == 0) {
		$intx = $x - $length;
		$inty = $y - $width;
	}
	else if ($orient == 1) {
		$intx = $x + $width;
		$inty = $y - $length;
	}
	else if ($orient == 2) {
		$intx = $x + $length;
		$inty = $y + $width;
	}
	else if ($orient == 3) {
		$intx = $x - $width;
		$inty = $y + $length;
	}
	
	if ($orient != $direction) {
		$px1 = min($x, $intx);
		$py1 = min($y, $inty);
		$px2 = max($x, $intx);
		$py2 = max($y, $inty);
	}
	else {
		$px1 = min($x, $intx, $x0);
		$py1 = min($y, $inty, $y0);
		$px2 = max($x, $intx, $x0);
		$py2 = max($y, $inty, $y0);
	}

	// Check for obstacles
	foreach ($obstacle as $row => $cols) {
		foreach ($cols as $col => $val) {
			if ($col >= $px1 && $col <= $px2 && $row >= $py1 && $row <= $py2) {
				return -1;
			}
		}
	}

	// Check map border
	if ($px2 > $xmax || $py2 > $ymax || $px1 < 0 || $py1 < 0)
		return -1;

	// Check for ships
	foreach ($ships as $key => $value) {
		$corrds = get_coords($ships[$key]);
		if (($coords[1][0] >= $px1 && $coords[1][0] <= $px2 && $coords[0][0] >= $py1 && $coords[0][0] <= $py2) ||($coords[1][0] >= $px1 && $coords[1][0] <= $px2 && $coords[0][1] >= $py1 && $coords[0][1] <= $py2) ||
			($coords[1][1] >= $px1 && $coords[1][1] <= $px2 && $coords[0][0] >= $py1 && $coords[0][0] <= $py2) ||
			($coords[1][1] >= $px1 && $coords[1][1] <= $px2 && $coords[0][1] >= $py1 && $coords[0][1] <= $py2)) {
			
			damage_ship( $ships[$key] )	
			return 0;
		}
	}
	
	// Still flying =)
	return 1;
}


public function move_ship( $map, $ship, $mv_num, $verbose ) {
	
	$x = $ship->x;
	$y = $ship->y;
	$orient = $ship->direction;

	if ($verbose == True) {
		print("Before Move. x: %2d, y: %2d, $dir: %2d\n"
			, $x, $y, $orient);
	}

	// Checking interval;
	if ($orient == 0)
		$y -= $mv_num;
	else if ($orient == 1)
		$x += $mv_num;
	else if ($orient == 2)
		$y += $mv_num;
	else if ($orient == 3)
		$x -= $mv_num;

	// Check if it's a valid move
	$valid = check_validity( $map, $ship, $x, $y, $orient );

	if ($verbose == True) {
		print("After Move. x: %2d, y: %2d, $dir: %2d, is valid: %d\n\n"
			, $x, $y, $orient, $valid);
	}

	if ($valid == 1 ) {
		// Change ship attributes
		$ship->x = $x;
		$ship->y = $y;
		return 1;
	}
	else if ($valid == -1) {
		// Ship destroyed
		return -1;
	}
	else {
		// Ship takes damage
		return 0;
	}
}

public function turn_ship( $map, $ship, $dir, $verbose ) {
	
	//Setup env
	$length = $ship->length;
	$width = $ship->width;
	$x = $ship->x;
	$y = $ship->y;
	$orient = $ship->direction; 

	if ($verbose == True) {
		print("Before Turn. x: %2d, y: %2d, $dir: %2d\n"
			, $x, $y, $orient);
	}

	// Initial size set for rotation with correction
	if ((($length + 1) % 2) ^ (($width + 1) % 2)) {
		$length -= ($length + 1) % 2;
		$width -= ($width + 1) % 2;
	}
	
	// Rotate and change coordinates
	if (($orient == 0 && $dir == 1) || ($orient == 3 && $dir == -1)) {
		$x -= intdiv($width + $length, 2);
		$y -= intdiv($width - $length, 2);
	}
	else if (($orient == 1 && $dir == 1) || ($orient == 0 && $dir == -1)) {
		$y -= intdiv($width + $length, 2);
		$x += intdiv($width - $length, 2);
	}
	else if (($orient == 2 && $dir == 1) || ($orient == 1 && $dir == -1)) {
		$x += intdiv($width + $length, 2);
		$y += intdiv($width - $length, 2);
	}
	else if (($orient == 3 && $dir == 1) || ($orient == 2 && $dir == -1)) {
		$y += intdiv($width + $length, 2);
		$x -= intdiv($width - $length, 2);
	}

	// Change ship direction
	if ($orient + $dir < 0)
		$orient = 4 + ($orient + $dir);
	else
		$orient = ($orient + $dir) % 4;

	// Check if it's a valid move
	$valid = check_validity( $map, $ship, $x, $y, $orient );

	if ($verbose == True) {
		print("After Turn. x: %2d, y: %2d, $dir: %2d, is valid: %d\n\n"
			, $x, $y, $orient, $valid);
	}


	if ($valid == 1 ) {
		// Change ship attributes
		$ship->x = $x;
		$ship->y = $y;
		$ship->direction = $orient;
		return 1;
	}
	else if ($valid == -1) {
		// Ship destroyed
		return -1;
	}
	else {
		// Ship takes damage
		return 0;
	}
}

?>