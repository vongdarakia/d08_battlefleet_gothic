$.getJSON( "/d08/actions/get_game_state.php", function( data ) {
	function set_ship(x, y, hor, ver, color) {
		var color = color == 1 ? "#F56C4E" : "#2C93E8"
		for (var j = y; j < y + ver; j++) {
			for (var i = x; i < x + hor; i++) {
				d3.selectAll(".row:nth-child("+ j +") .square:nth-child("+ i +")").style("fill", color);
			}
		}
	}

	var x1, y1, x2, y2, w1, h1, w2, h2;
	var players = data.players;
	x1 = players[0]['ships'][0]['x'] + 1;
	y1 = players[0]['ships'][0]['y'] + 1;
	x2 = players[1]['ships'][0]['x'] + 1;
	y2 = players[1]['ships'][0]['y'] + 1;
	h1 = players[0]['ships'][0]['hor'];
	v1 = players[0]['ships'][0]['ver'];
	h2 = players[1]['ships'][0]['hor'];
	v2 = players[1]['ships'][0]['ver'];
	console.log("player1: (" + x1 + ", " + y1 + ") hor: " + h1 + " ver: " + v1);
	console.log("player2: (" + x2 + ", " + y2 + ") hor: " + h2 + " ver: " + v2);
	set_ship(x1, y1, h1, v1, 1);
	set_ship(x2, y2, h2, v2, 2);
});