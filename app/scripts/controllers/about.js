'use strict';

/**
 * @ngdoc function
 * @name shoutApp.controller:AboutCtrl
 * @description
 * # AboutCtrl
 * Controller of the shoutApp
 */
angular.module('shoutApp')
  .controller('AboutCtrl', function ($scope) {
    $scope.awesomeThings = [
      'HTML5 Boilerplate',
      'AngularJS',
      'Karma'

    ];
  });
