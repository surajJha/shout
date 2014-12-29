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
  });
