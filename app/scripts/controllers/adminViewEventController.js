'use strict';

/**
 * @ngdoc function
 * @name shoutApp.controller:adminViewEventController
 * @description
 * # adminViewEventController
 * Controller of the shoutApp
 */
angular.module('shoutApp')
  .controller('adminViewEventController', function ($scope, $rootScope, adminTaskFactory) {
        $scope.eventData ='';
        $scope.imageUrl = '';
      $scope.init = function () {
          var organiser_id = 1; //change to sessionid afterwards
          adminTaskFactory.getAllEvents(organiser_id).then(function (result) {
              $scope.eventData = result;
              var index = $scope.eventData[0]['event_image_name'].indexOf('/shout');
              $scope.imageUrl = $scope.eventData[0]['event_image_name'].substring(index);
              console.log($scope.imageUrl);
              for(var i = 0;i<result.length;i++)
              console.log(result[i]);
          })
      }
        $scope.init();
        function onGoogleReady() {
            angular.bootstrap(document.getElementById("map"), ['app.ui-map']);
        }

        $scope.mapOptions = {
            center: new google.maps.LatLng(19.2147, 72.850),
            zoom: 15,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        $scope.addMarker = function ($event, $params){
            $scope.myMarkers.push(new google.maps.Marker({
                map: $scope.myMap,
                position: $params[0].latLng
            }));
        };



  });
