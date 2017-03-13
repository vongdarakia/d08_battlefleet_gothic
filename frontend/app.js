var app = angular.module('myApp', ['ui.router']);

app.controller('myCtrl', ['$scope', '$http', '$state', function($scope, $http, $state) {
    $scope.players = [];
    $scope.ships = [];
    $scope.currentPlayer = 0;
    $scope.currentShip = 0;
    $scope.currentPhase = 0;

    function draw_ship(x, y, hor, ver, color) {
        var color = color == 1 ? "#F56C4E" : "#2C93E8"
        for (var j = y; j < y + ver; j++) {
            for (var i = x; i < x + hor; i++) {
                d3.selectAll(".row:nth-child("+ j +") .square:nth-child("+ i +")").style("fill", color);
            }
        }
    }

    function updateGame(response) {
        $scope.gameState = response.data;
        var players = $scope.gameState.players;
        for (var p = 0; p < $scope.gameState.players.length; p++) {
            var player = players[p];
            for (var s = 0; s < player.ships.length; s++) {
                var ship = player.ships[s];
                var x = ship.x + 1;
                var y = ship.y + 1;
                var h = ship.hor;
                var v = ship.ver;
                draw_ship(x, y, h, v, p);
            }
        }
        console.log(response.data);
        resetp1();
        resetp2();
        console.log($scope.gameState.players[$scope.currentPlayer].ships[$scope.currentShip]);
    }

    $http.get("/d08/actions/get_game_state.php")
    .then(function(response) {
        updateGame(response);
    });

    function resetp1() {
        $scope.p1 = {
            speed : 0,
            shield : 0,
            weapon : 0,
            repair : 0,
            usepp : function(n, type) {
                if (( n > 0 && $scope.gameState.players[$scope.currentPlayer].ships[$scope.currentShip].pp > 0) || ( n < 0 && $scope.p1[type] > 0)) {
                    $scope.p1[type] += n;
                    $scope.gameState.players[$scope.currentPlayer].ships[$scope.currentShip].pp -= n
                }
            }
        };
    }

    function resetp2() {
        $scope.p2 = {
            minSpeed : $scope.gameState.players[$scope.currentPlayer].ships[$scope.currentShip].minSpeed,
            maxSpeed : $scope.gameState.players[$scope.currentPlayer].ships[$scope.currentShip].maxSpeed,
            // usepp : function(n, type) {
            //     if (( n > 0 && $scope.gameState.players[$scope.currentPlayer].ships[$scope.currentShip].pp > 0) || ( n < 0 && $scope.p1[type] > 0)) {
            //         $scope.p1[type] += n;
            //         $scope.gameState.players[$scope.currentPlayer].ships[$scope.currentShip].pp -= n
            //     }
            // }
        };
    }

    $scope.sendp1 = function() {
        var inData = {
            'player_id' : $scope.gameState.players[$scope.currentPlayer]['_id'],
            'ship_id': $scope.gameState.players[$scope.currentPlayer].ships[$scope.currentShip]['_id'],
            'speed': $scope.p1.speed,
            'shield': $scope.p1.shield,
            'weapon': $scope.p1.weapon,
            'repair': $scope.p1.repair };
        $http({
            url: "/d08/actions/p0_spend_pp.php",
            method: "GET",
            headers: {'Content-Type': "application/x-www-form-urlencoded"},
            params: inData
        }).then(function successCallback(response) {
            updateGame(response);
            $scope.currentPhase = 1.5;
            if ($scope.currentShip < $scope.gameState.players[$scope.currentPlayer].ships.length - 1) {
                $scope.currentShip++;
                $scope.currentPhase = 1;
            } else if ( $scope.currentPlayer < $scope.gameState.players.length - 1 ) {
                $scope.currentPlayer++;
                $scope.currentShip = 0;
                $scope.currentPhase = 1;
            } else {
                $scope.currentPlayer = 0;
                $scope.currentShip = 0;
                $scope.currentPhase = 2;
            };
        }, function errorCallback(response) {
            console.log("error");
            console.log(response);
        });
    };

    $scope.sendp2move = function() {
        var inData = {
            'player_id' : $scope.gameState.players[$scope.currentPlayer]['_id'],
            'ship_id': $scope.gameState.players[$scope.currentPlayer].ships[$scope.currentShip]['_id'],
            'speed': $scope.p1.speed,
            'shield': $scope.p1.shield,
            'weapon': $scope.p1.weapon,
            'repair': $scope.p1.repair };
        $http({
            url: "/d08/actions/p1_move_ship.php",
            method: "GET",
            headers: {'Content-Type': "application/x-www-form-urlencoded"},
            params: inData
        }).then(function successCallback(response) {
            updateGame(response);
            $scope.currentPhase = 1.5;
            if ($scope.currentShip < $scope.gameState.players[$scope.currentPlayer].ships.length - 1) {
                $scope.currentShip++;
                $scope.currentPhase = 1;
            } else if ( $scope.currentPlayer < $scope.gameState.players.length - 1 ) {
                $scope.currentPlayer++;
                $scope.currentShip = 0;
                $scope.currentPhase = 1;
            } else {
                $scope.currentPlayer = 0;
                $scope.currentShip = 0;
                $scope.currentPhase = 2;
            };
        }, function errorCallback(response) {
            console.log("error");
            console.log(response);
        });
    };
    $scope.sendp2turn = function() {
        var inData = {
            'player_id' : $scope.gameState.players[$scope.currentPlayer]['_id'],
            'ship_id': $scope.gameState.players[$scope.currentPlayer].ships[$scope.currentShip]['_id'],
            'speed': $scope.p1.speed,
            'shield': $scope.p1.shield,
            'weapon': $scope.p1.weapon,
            'repair': $scope.p1.repair };
        $http({
            url: "/d08/actions/p1_turn_ship.php",
            method: "GET",
            headers: {'Content-Type': "application/x-www-form-urlencoded"},
            params: inData
        }).then(function successCallback(response) {
            updateGame(response);
            $scope.currentPhase = 1.5;
            if ($scope.currentShip < $scope.gameState.players[$scope.currentPlayer].ships.length - 1) {
                $scope.currentShip++;
                $scope.currentPhase = 1;
            } else if ( $scope.currentPlayer < $scope.gameState.players.length - 1 ) {
                $scope.currentPlayer++;
                $scope.currentShip = 0;
                $scope.currentPhase = 1;
            } else {
                $scope.currentPlayer = 0;
                $scope.currentShip = 0;
                $scope.currentPhase = 2;
            };
        }, function errorCallback(response) {
            console.log("error");
            console.log(response);
        });
    };
}]);
