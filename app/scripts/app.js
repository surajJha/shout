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
    'ngTouch',
    'ui.router'
  ])

    .config(function($stateProvider, $urlRouterProvider){

        // For any unmatched url, send to /route1
        $urlRouterProvider.otherwise("/about")

        $stateProvider
            .state('about', {
                //abstract:true,
                url:'/about',

                views:{
                    '':{
                        templateUrl: 'views/about.html'
                    },
                    'sidebar@about':{
                        url:"",
                        templateUrl:'views/admin.html',
                        controller: 'adminHomeController'

                    },
                    'content@about':{
                        url:"",
                        templateUrl:'views/main.html',
                        controller: 'MainCtrl'
                    }
                }
            })
            //.state('about.main', {
            //    url:'/main',
            //    templateUrl: 'views/main.html',
            //    controller: 'MainCtrl'
            //})
            //.state('about.admin', {
            //    url:'/admin',
            //    templateUrl: 'views/admin.html',
            //    controller: 'adminHomeController'
            //})
    })
  .run(function($rootScope){
        /**
         * base URL  points to the server where PHP interpreter
         * is present. PORT 80 used by apache has the interpreter
         * port 9000 used by the grunt server cannot run PHP
         * @type {string}
         */
    $rootScope.baseUrl = 'http://localhost:80'
  })





//.config(function ($routeProvider) {
//  $routeProvider
//    .when('/', {
//      templateUrl: 'views/main.html',
//      controller: 'MainCtrl'
//    })
//    .when('/about', {
//      templateUrl: 'views/about.html',
//      controller: 'AboutCtrl'
//    })
//    .when('/admin', {
//      templateUrl: 'views/admin.html',
//      controller: 'adminHomeController'
//    })
//    .otherwise({
//      redirectTo: '/'
//    });
//
//})
