'use strict';

/**
 * @ngdoc function
 * @name shoutApp.controller:adminAddEventController
 * @description
 * # adminAddEventController
 * Controller of the shoutApp
 */
angular.module('shoutApp')
  .controller('adminAddEventController', function ($scope) {
        /**
         * datepicker function for activating
         * datepicker functionality
         */
    //var datepicker = (function () {

    //})();

        /**
         * the generateDatepicker function generates the datepicker
         * widget as per the value of dropworn
         */
        var generateDatepicker = (function () {
            $scope.days = [1,2,3,4,5,6,7];
            $scope.day = $scope.days[0];
            $scope.change = function (no_of_days) {
                $scope.day = no_of_days;
            }


        })();
  });
