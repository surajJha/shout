'use strict';

/**
 * @ngdoc function
 * @name shoutApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the shoutApp
 */
angular.module('shoutApp')
  .controller('MainCtrl', function ($scope) {
    $scope.awesomeThings = [
      'HTML5 Boilerplate',
      'AngularJS',
      'Karma'
    ];
        $scope.counter=0;

        setInterval(function(){

    console.log("running");
            $scope.counter++;
            console.log($scope.counter);
            $scope.$digest();
          //  $scope.$watch(function(scope){
          //      return scope.counter;
          //  },function(){
          //
          //  });
        },1000)
  });
