'use strict';

/**
 * @ngdoc overview
 * @name shoutApp
 * @description
 * # shoutApp
 *
 * Main module of the application.
 */
angular
  .module('shoutApp', [
    'ngAnimate',
    'ngCookies',
    'ngMessages',
    'ngResource',
    'ngRoute',
    'ngSanitize',
    'ngTouch'
  ])
  .config(function ($routeProvider) {
    $routeProvider
      .when('/', {
        templateUrl: 'views/main.html',
        controller: 'MainCtrl'
      })
      .when('/about', {
        templateUrl: 'views/about.html',
        controller: 'AboutCtrl'
      })
      .when('/admin', {
        templateUrl: 'views/admin.html',
        controller: 'adminHomeController'
      })
      .otherwise({
        redirectTo: '/'
      });
  });
