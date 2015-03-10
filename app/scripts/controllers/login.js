'use strict';

/**
 * @ngdoc function
 * @name shoutApp.controller:loginController
 * @description
 * # loginController
 * Controller of the shoutApp
 */
angular.module('shoutApp')
  .controller('loginController', function ($scope, loginService, $log) {
        $scope.user = {}
        $scope.user.username = '';
        $scope.user.password = '';

        $scope.login = function () {
            loginService.login($scope.user).then(function (res) {
               if(res == 'success'){
                   console.log("success");
               }
                else{
                   console.log(res);
               }
            })
        }
  });
