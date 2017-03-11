<?php
require_once 'Spaceship.class.php'


// Orientation/Direction: 0 - N, 1 - E, 2 - S, 3 - W

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
	$sw = $orient % 2;
	$intx = $x + $length * (1 - $sw) + $width  * $sw;
	$inty = $y + $length  * $sw + $width  * (1 - $sw);

	// Check for obstacles collisions
	foreach ($obstacle as $row => $cols) {
		foreach ($cols as $col => $val) {
			if ($col >= $x0 && $col <= $intx && $row >= $y0 && $row <= $inty) {
				return -1;
			}
		}
	}

	// Check map border collisions
	if ($intx > $xmax || $inty > $ymax || $x < 0 || $y < 0)
		return -1;

	// Check for ships collisions
	foreach ($ships as $key => $value) {
		
		//env
		$shp_orient = $ships[$key]->direction;
		$shp_length = $ships[$key]->length;
		$shp_width = $ships[$key]->width;
		$shp_x = $ships[$key]->x;
		$shp_y = $ships[$key]->y;

		$shp_sw = $shp_orient % 2;
		$shp_intx = $shp_x + $shp_length * (1 - $shp_sw) + $shp_width  * $shp_sw;
		$shp_inty = $shp_y + $shp_length  * $shp_sw + $shp_width  * (1 - $shp_sw);

		if ($orient == $direction) {
			// Collisions during sraight flying
			if (($shp_x >= $x0 && $shp_x <= $intx && $shp_y >= $y0 && $shp_x <= $inty) ||
				($shp_x >= $x0 && $shp_x <= $intx && $shp_inty >= $y0 && $shp_inty <= $inty) ||
				($shp_intx >= $x0 && $shp_intx <= $intx && $shp_y >= $y0 && $shp_y <= $inty) ||
				($shp_intx >= $x0 && $shp_intx <= $intx && $shp_inty >= $y0 && $shp_inty <= $inty)) {
				
				// That ship should take damage too if our speed is greater than normal
				//  damage_ship( $ships[$key] );
				// 	damage_ship( $ship );
				
				// Ships become stationary
				// attr->stationary = True;

				// Moved ship stop on collisin, change ship attributes
				if ($orient == 0)
					$ship->y = $shp_inty;
				else if ($orient == 2)
					$ship->y = $shp_y - $ship->width;
				else if ($orient == 1)
					$ship->x = $shp_x - $ship->width;
				else if ($orient = 3)
					$ship->x = $shp_intx;
				return 0;
			}
		}
		else {
			// Collisions during turning
			if (($shp_x >= $x && $shp_x <= $intx && $shp_y >= $y && $shp_x <= $inty) ||
				($shp_x >= $x && $shp_x <= $intx && $shp_inty >= $y && $shp_inty <= $inty) ||
				($shp_intx >= $x && $shp_intx <= $intx && $shp_y >= $y && $shp_y <= $inty) ||
				($shp_intx >= $x && $shp_intx <= $intx && $shp_inty >= $y && $shp_inty <= $inty)) {
				
				// That ship should take damage too if our speed is greater than normal
				// Damaged ship should become stationary
				damage_ship( $ships[$key] )	
				return 0;
			}
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

	// Correction should be set and implemented in rotation section below
	// if ((($length + 1) % 2) ^ (($width + 1) % 2)) {
	// 	$length -= ($length + 1) % 2;
	// 	$width -= ($width + 1) % 2;
	// }
	
	// Rotate and change coordinates
	if ($orient == 0 || $orient == 2) {
		$x -= intdiv($width - $length, 2);
		$y += intdiv($length - $width, 2);
	}
	else if ($orient == 1 || $orient == 3) {
		$x += intdiv($length - $width, 2);
		$y -= intdiv($length - $width, 2);
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
}

?>