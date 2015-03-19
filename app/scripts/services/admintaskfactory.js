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
    /**
    Add all the public functions to the factory object
    and then return the factory object which
    will be then available to the controller
    which is using this factory
     **/

    factory.getAllEvents = function() {
      var defer = $q.defer();

      $http.get($rootScope.baseUrl + '/server/adminController.php?func=getAllEvents')
        .success(function(res){
          defer.resolve(res);
        })
        .error(function (err, status) {
          defer.reject(err);
        })

      return defer.promise;
    }

    factory.addNewEvent = function(formData) {
        var defer = $q.defer();

        $http.post($rootScope.baseUrl + '/server/adminController.php?func=addEvent', formData)
            .success(function(res){
                defer.resolve(res);
            })
            .error(function (err, status) {
                defer.reject(err);
            })

        return defer.promise;
    }

    factory.loadImages = function(path) {
        var defer = $q.defer();
        $http.get($rootScope.baseUrl + '/server/resize.php?imgpath='+path)
            .success(function(res){
                defer.resolve(res);

            })
            .error(function (err, status) {
                defer.reject(err);
            })

        return defer.promise;
    }

    factory.getEventCategory = function () {
        var defer = $q.defer();

        $http.get($rootScope.baseUrl + '/server/adminController.php?func=getEventCategory')
            .success(function(res){
                defer.resolve(res.data);
            })
            .error(function (err, status) {
                defer.reject(err);
            })

        return defer.promise;
    }
        factory.getEventCity = function () {
            var defer = $q.defer();

            $http.get($rootScope.baseUrl + '/server/adminController.php?func=getEventCity')
                .success(function(res){
                    defer.resolve(res.data);
                })
                .error(function (err, status) {
                    defer.reject(err);
                })

            return defer.promise;
        }

        factory.getEventArea = function (city) {
            var defer = $q.defer();

            $http.get($rootScope.baseUrl + '/server/adminController.php?func=getEventArea&city='+city)
                .success(function(res){
                    defer.resolve(res.data);
                })
                .error(function (err, status) {
                    defer.reject(err);
                })

            return defer.promise;
        }

        factory.updateEventDetails = function (modalFormData) {
            var defer = $q.defer();

            $http.post($rootScope.baseUrl + '/server/adminController.php?func=updateEventDetails', modalFormData)
                .success(function(res){
                    defer.resolve(res);

                })
                .error(function (err, status) {
                    defer.reject(err);
                })

            return defer.promise;
        }

        factory.deleteEvent = function(event_detail_id){
            var defer = $q.defer();

            $http.get($rootScope.baseUrl + '/server/adminController.php?func=deleteEvent&event_detail_id='+event_detail_id)
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


