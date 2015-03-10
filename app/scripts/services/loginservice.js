'use strict';

/**
 * @ngdoc service
 * @name shoutApp.loginService
 * @description
 * # loginService
 * Factory in the shoutApp.
 */
angular.module('shoutApp')
  .factory('loginService', function ($rootScope,$q, $http) {
    // Service logic
    // ...


    // Public API here
    return {
      login: function ( user ) {
          var defer = $q.defer();

          $http.post($rootScope.baseUrl + '/server/login.php?func=login', user)
              .success(function(res){
                  defer.resolve(res);
              })
              .error(function (err, status) {
                  defer.reject(err);
              })
          return defer.promise;
      },

        logout: function ( ) {
            var defer = $q.defer();

            $http.get($rootScope.baseUrl + '/server/login.php?func=logout')
                .success(function(res){
                    defer.resolve(res);
                })
                .error(function (err, status) {
                    defer.reject(err);
                })
            return defer.promise;
        }
    };
  });
