'use strict';

/**
 * @ngdoc function
 * @name shoutApp.controller:adminAddEventController
 * @description
 * # adminAddEventController
 * Controller of the shoutApp
 */
angular.module('shoutApp')
    .controller('adminController', function ($scope, $rootScope, $http) {
        $scope.testa = function(a){
            $scope.result='';
            console.log("aaya");
            console.log($scope.testObj);
        }
    });
