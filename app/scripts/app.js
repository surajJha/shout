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
    'ui.router',
        'ui.utils',
    'angularFileUpload',
    'ui.bootstrap',
        'ui.map'

  ])

    .config(function($stateProvider, $urlRouterProvider){

        // For any unmatched url, send to /route1
        $urlRouterProvider.otherwise("/admin")

        $stateProvider
            .state('admin', {
                //abstract:true,
                url:'/admin',

                views:{
                    '':{
                        templateUrl: 'views/admin.html'
                    },
                  'content@admin': {
                        url: "",
                        templateUrl: 'views/partials/adminViewEvent.html'
                        //controller: 'MainCtrl'
                    }

                }
            })
            .state('admin.add', {
                url:'/add',
                templateUrl:'views/partials/adminAddEvent.html',
                controller : 'adminAddEventController'

            })
            .state('admin.view', {
                url:'/view',
                templateUrl:'views/partials/adminViewEvent.html',
                controller : 'adminViewEventController'

            })

    })
  .run(function($rootScope){
        /**
         * base URL  points to the server where PHP interpreter
         * is present. PORT 80 used by apache has the interpreter
         * port 9000 used by the grunt server cannot run PHP
         * @type {string}
         */
    $rootScope.baseUrl = 'http://localhost:80/shout'
  })
