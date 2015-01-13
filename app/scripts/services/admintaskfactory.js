'use strict';

/**
 * @ngdoc service
 * @name shoutApp.adminTaskFactory
 * @description
 * # adminTaskFactory
 * Factory in the shoutApp.
 */
angular.module('shoutApp')
  .factory('adminTaskFactory', function ($http, $q, $rootScope) {
    // Service logic
    // ...

    var factory = {};

    // Public API here
    /*
    Add all the public functions to the factory object
    and then return the factory object which
    will be then avaibale to the controller
    which is using this factory
     */

    factory.getAllEvents = function() {
      var defer = $q.defer();

      $http.get($rootScope.baseUrl + '/shout/server/rest.php?f=getdetail&name=suraj')
        .success(function(res){
          defer.resolve(res);
        })
        .error(function (err, status) {
          defer.reject(err);
        })

      return defer.promise;
    }
        /**
         * addnewevent takes the formdata model as input
         * and makes a post request to the adminController
         * @param formData
         * @returns {*}
         */
    factory.addNewEvent = function(formData) {
        var defer = $q.defer();

        $http.post($rootScope.baseUrl + '/server/adminController.php?func=addEvent', formData)
            .success(function(res){
                defer.resolve(res);
                console.log(res);
            })
            .error(function (err, status) {
                defer.reject(err);
            })

        return defer.promise;
    }

    factory.EditEvent = function() {

    }

    factory.deleteEvent = function() {

    }

    factory.GetAllEventImages = function() {

    }

    factory.changeName = function (newname) {
      var defer = $q.defer();

      $http.get($rootScope.baseUrl + '/shout/server/rest.php?f=changeName&name='+newname)
        .success(function(res){
          defer.resolve(res);
        })
        .error(function (err, status) {
          defer.reject(err);
        })

      return defer.promise;
    }





   return factory;
  });


