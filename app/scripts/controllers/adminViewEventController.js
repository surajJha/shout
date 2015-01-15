'use strict';

/**
 * @ngdoc function
 * @name shoutApp.controller:adminViewEventController
 * @description
 * # adminViewEventController
 * Controller of the shoutApp
 */
angular.module('shoutApp')
  .controller('adminViewEventController', function ($scope, $http) {
        $scope.loaded = false;
        console.log($scope.loaded)
       $http.jsonp('http://filltext.com/?rows=10&delay=3&fname={firstName}&callback=JSON_CALLBACK').
           success(function(data){
               $scope.people = data;
               $scope.loaded = true;
               console.log($scope.loaded)
           })


  });
