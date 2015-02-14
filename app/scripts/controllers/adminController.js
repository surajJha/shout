'use strict';

/**
 * @ngdoc function
 * @name shoutApp.controller:adminAddEventController
 * @description
 * # adminAddEventController
 * Controller of the shoutApp
 */
angular.module('shoutApp')
    .controller('adminController', function ($scope, $rootScope, $http, adminTaskFactory) {
        $scope.submit = function() {

            adminTaskFactory.getEventBySearch($scope.testObj.title, $scope.testObj.description).then(function(result)
            {

                console.log(result);
            })
            //
            //alert('About to submit ' + $scope.testObj.title +' '+$scope.testObj.description);
            //console.log($scope.testObj);
        }
    });
