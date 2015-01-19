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
        $scope.formData = {};
        $scope.formData.event_detail_id = [];
        $scope.formData.event_name = [];
        $scope.formData.event_category = [];
        $scope.formData.event_cost = [];
        $scope.formData.event_overview = [];
        $scope.formData.event_hashtags = [];
        $scope.formData.venue_name = [];
        $scope.formData.event_area = [];
        $scope.formData.event_location = [];
        $scope.formData.image = [];
        $scope.formData.schedule = [];
        $scope.formData.result_length = [];
        $scope.formData.date_array = [];
        $scope.formData.datetime = [];
        $scope.formData.date_temp = [];
      $scope.init = function () {
          var organiser_id = 1; //change to sessionid afterwards
          adminTaskFactory.getAllEvents(organiser_id).then(function (result) {
              //console.log(result.length);
              //console.log(result[0]);

              var items = [];
              for(var i =0;i<result.length;i++){
                  items.push(i);
              }
              $scope.formData.result_length = items;

              for(var i=0; i< result.length; i++){
                  $scope.formData.event_detail_id[i] = result[i].event_detail_id;
                  $scope.formData.event_name[i] = result[i].event_name;
                  $scope.formData.event_category[i] = result[i].category_name;
                  $scope.formData.event_cost[i] = result[i].event_cost;
                  $scope.formData.event_overview[i] = result[i].event_overview;
                  $scope.formData.event_hashtags[i] = result[i].event_hashtags;
                  $scope.formData.venue_name[i] = result[i].venue_name;
                  $scope.formData.event_area[i] = result[i].event_area;
                  $scope.formData.event_location[i] = result[i].event_location;
                  $scope.formData.image[i] = result[i].image;
                  $scope.formData.schedule[i] = result[i].schedule;

                  $scope.formData.date_array[i] = $scope.formData.schedule[i].split(",");


              }

              for(var k=0; k<$scope.formData.date_array.length; k++){
                  for(var j=0; j<$scope.formData.date_array[k].length; j++){
                      $scope.formData.date_temp[k] = $scope.formData.date_array[k][j].split("=");
                      console.log($scope.formData.date_temp[k]);
                  }
              }
             //console.log($scope.formData.date_array[1].length);


          })
      }
        $scope.init();
        //function onGoogleReady() {
        //    angular.bootstrap(document.getElementById("map"), ['app.ui-map']);
        //}
        //
        //$scope.mapOptions = {
        //    center: new google.maps.LatLng(19.2147, 72.850),
        //    zoom: 15,
        //    mapTypeId: google.maps.MapTypeId.ROADMAP
        //};
        //
        //$scope.addMarker = function ($event, $params){
        //    $scope.myMarkers.push(new google.maps.Marker({
        //        map: $scope.myMap,
        //        position: $params[0].latLng
        //    }));
        //};



  });
