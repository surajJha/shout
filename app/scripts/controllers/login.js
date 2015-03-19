'use strict';

/**
* @ngdoc function
* @name shoutApp.controller:loginController
* @description
* # loginController
* Controller of the shoutApp
*/
angular.module('shoutApp')
  .controller('loginController', function ($scope, loginService, sessionService, $location, $state) {
        $scope.user = {}
        $scope.user.username = '';
        $scope.user.password = '';

        $scope.login = function () {
            loginService.login($scope.user).then(function (res) {
               if(res.message == 'success'){
                   sessionService.set("user", res.data);
                   $state.go('admin')

               }
                else{
                   $state.go('login')
               }
            })
        }

        $scope.logout = function(){
            loginService.logout().then(function(res){
                if(res.message = 'success'){
                    sessionService.destroy('user')
                    $state.go('login');
                }
            })

        }

       //$scope.isLogged = function() {
       //    if (sessionService.get('user')) return true;
       //    else return false;
       //}

  });
