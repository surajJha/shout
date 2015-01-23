'use strict';

/**
 * @ngdoc directive
 * @name shoutApp.directive:eventwidget
 * @description
 * # eventwidget
 */
angular.module('shoutApp')
  .directive('eventwidget', function () {
    return {
      templateUrl: '/views/partials/eventwidget.html',
      restrict: 'E',
      link: function postLink(scope, element, attrs) {

      }
    };
  });
