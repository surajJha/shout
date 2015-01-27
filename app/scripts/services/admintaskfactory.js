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
        /**
         * Function returns all the events
         * belonging to a perticular client/admin
         * @returns {*}
         */
    factory.getAllEvents = function(organiser_id) {
      var defer = $q.defer();

      $http.get($rootScope.baseUrl + '/server/adminController.php?func=getAllEvents&organiser_id='+organiser_id)
        .success(function(res){
           //   console.log(res);
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

    factory.loadImages = function(path) {
        var defer = $q.defer();
        $http.get($rootScope.baseUrl + '/server/resize.php?imgpath='+path)
            .success(function(res){
              //  console.log(res);
                defer.resolve(res);
              // console.log(res);

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
               // console.log(res);
            })
            .error(function (err, status) {
                defer.reject(err);
            })

        return defer.promise;
    }

        factory.getEventArea = function () {
            var defer = $q.defer();

            $http.get($rootScope.baseUrl + '/server/adminController.php?func=getEventArea')
                .success(function(res){
                    defer.resolve(res.data);
                    // console.log(res);
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
                     console.log(res);
                })
                .error(function (err, status) {
                    defer.reject(err);
                })

            return defer.promise;
        }






   return factory;
  });


