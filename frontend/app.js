var app = angular.module('myApp', ['ui.router']);

// app.config([
// '$stateProvider',
// '$urlRouterProvider',
// '$locationProvider',
// '$httpProvider',
// function($stateProvider, $urlRouterProvider, $httpProvider ) {
//     $urlRouterProvider.otherwise("/");

//     $stateProvider
//     .state('phase1', {
//         url: "/phase1",
//         templateUrl: "/d08/frontend/test.html"
//     })

//     .state('phase2', {
//         url: "/phase2",
//         templateUrl: "/static/partials/profile/albums.html"
//     })

//     .state('phase3', {
//         url: "/phase3/:album/:filename",
//         templateUrl: "/static/partials/profile/media.html",
//         controller: function($stateParams, $scope, $http) {
//             // .....
//         }
//     })
// }]);

app.controller('myCtrl', ['$scope', '$http', '$state', function($scope, $http, $state) {
    $scope.players = [];
    $scope.ships = [];

    $http.get("/d08/actions/get_game_state.php")
    .then(function(response) {
        $scope.gameState = response.data;
        function draw_ship(x, y, hor, ver, color) {
            var color = color == 1 ? "#F56C4E" : "#2C93E8"
            for (var j = y; j < y + ver; j++) {
                for (var i = x; i < x + hor; i++) {
                    d3.selectAll(".row:nth-child("+ j +") .square:nth-child("+ i +")").style("fill", color);
                }
            }
        }
        var players = $scope.gameState.players;
        for (var p = 0; p < $scope.gameState.players.length; p++) {
            var player = players[p];
            $scope.players.push(player['_id']);
            for (var s = 0; s < player.ships.length; s++) {
                var ship = player.ships[s];
                $scope.ships.push(ship['_id']);
                var x = ship.x + 1;
                var y = ship.y + 1;
                var h = ship.hor;
                var v = ship.ver;
                draw_ship(x, y, h, v, p);
                $scope.pp = ship.pp
            }
        }
    });

    $scope.p1 = {
        speed : 0,
        shield : 0,
        weapon : 0,
        repair : 0,
        usepp : function(n, type) {
            if (( n > 0 && $scope.pp > 0) || ( n < 0 && $scope.p1[type] > 0)) {
                $scope.p1[type] += n;
                $scope.pp -= n
            }
        }
    };
}]);