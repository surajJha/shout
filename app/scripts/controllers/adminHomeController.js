'use strict';

/**
 * @ngdoc function
 * @name shoutApp.controller:AdmintaskcontrollerCtrl
 * @description
 * # AdmintaskcontrollerCtrl
 * Controller of the shoutApp
 */
angular.module('shoutApp')
  .controller('adminHomeController', function ($scope,adminTaskFactory) {
    $scope.news = '';
    $scope.one = function(){
      adminTaskFactory.getAllEvents().then(function(response){
        $scope.msg = response;
      });
    }
    $scope.one();

    $scope.changeName = function() {
     // console.log($scope.news);
      adminTaskFactory.changeName($scope.news).then(function(response){
      //  console.log(response);
        $scope.one();
      })
    }

  });
