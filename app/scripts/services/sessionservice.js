'use strict';

/**
* @ngdoc service
* @name shoutApp.sessionService
* @description
* # sessionService
* Factory in the shoutApp.
*/
angular.module('shoutApp')
  .factory('sessionService', function () {

    return {
        set: function (key, value) {
            return sessionStorage.setItem(key, value)
         },

        get: function (key) {
            return sessionStorage.getItem(key)
        },

        destroy: function (key) {
            return sessionStorage.removeItem(key)
        }

    };
  });
