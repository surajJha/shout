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
        $scope.formData.datetime = [];
        $scope.formData.result_length = [];
        $scope.formData.no_of_days = [];

      $scope.init = function () {
          var organiser_id = 1; //change to sessionid afterwards
          adminTaskFactory.getAllEvents(organiser_id).then(function (result) {

              /** Storing the length in
              * result_length so that it can be
               * used in ng-repeat to
               * repeat the loop and create the div
              */
                //  console.log(result);
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
                 // $scope.formData.image[i] = result[i].image;
                  $scope.formData.datetime[i] = result[i].datetime;
                  $scope.formData.no_of_days[i] = $scope.formData.datetime[i].length;

                  //console.log($scope.formData.datetime[i][0].date);

              }

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



  })
.controller('ModalDemoCtrl', function ($scope, $modal, $log) {

        $scope.open = function (size, formData, id) {

            var modalInstance = $modal.open({
                templateUrl: 'myModalContent.html',
                controller: 'ModalInstanceCtrl',
                size: size,
                resolve: {
                    id: function(){
                      return id;
                    },
                    formData: function () {
                        return formData;
                    }
                }
            });

            modalInstance.result.then(function (selectedItem) {
                $scope.selected = selectedItem;
            }, function () {
                $log.info('Modal dismissed at: ' + new Date());
            });
        };
    })
    .controller('ModalInstanceCtrl', function ($scope, $modalInstance, id, formData) {
        $scope.formData = formData;
        $scope.id = id;


    $scope.ok = function () {
        $modalInstance.close($scope.id);
    };

    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
    };
});
