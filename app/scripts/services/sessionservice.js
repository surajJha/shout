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

        get: function () {
            return sessionStorage.getItem(key)
        },

        destroy: function () {
            return sessionStorage.removeItem(key)
        }

    };
  });
