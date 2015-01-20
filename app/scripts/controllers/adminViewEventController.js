'use strict';

/**
 * @ngdoc function
 * @name shoutApp.controller:adminViewEventController
 * @description
 * # adminViewEventController
 * Controller of the shoutApp
 */
angular.module('shoutApp')
  .controller('adminViewEventController', function ($scope, $rootScope, adminTaskFactory, $modal, $log) {
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
                  $scope.formData.image[i] = result[i].image;
                  $scope.formData.datetime[i] = result[i].datetime;
                  $scope.formData.no_of_days[i] = $scope.formData.datetime[i].length;



                  //console.log($scope.formData.datetime[i][0].date);

              }

          }); //getallevents func ends here
      }
        $scope.init();


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

            for(var i = 0;i<$scope.formData.image[id].length;i++) {
              //  console.log($scope.formData.image[id][i].image_path);
               adminTaskFactory.loadImages($scope.formData.image[id][i].image_path).then(function(result){
                   $scope.formData.image_encoded_path_array[i] = result;

               })
                console.log("image path  "+$scope.formData.image_encoded_path_array);
            }

            modalInstance.result.then(function (selectedItem) {
                $scope.selected = selectedItem;
            }, function () {
                $log.info('Modal dismissed at: ' + new Date());
            });
        };




  })
    .controller('ModalInstanceCtrl', function ($scope, $modalInstance, id, formData, adminTaskFactory) {
        $scope.event_categories = [];
        $scope.event_areas = [];
        $scope.formData = formData;
        $scope.id = id;
        $scope.formData.datetime_edit = formData.datetime;
       $scope.change_event_schedule_flag = false;
         //
         //console.log(formData);
        /**
         * Init function will be called as soon as the
         * page loads to initialize required params
         */
        $scope.init = function() {
            /**
             *  FIll the category dropdown with initial data
             */
            adminTaskFactory.getEventCategory().then(function (result) {
                for(var i = 0;i<result.length;i++){
                    $scope.event_categories[i] = result[i][0];
                }

            })
            /**
             *  FIll the area dropdown with initial data
             */
            adminTaskFactory.getEventArea().then(function(result){
              //  console.log(result);
                for(var i = 0;i<result.length;i++){
                    $scope.event_areas[i] = result[i][0];
                }
            })
        }
        $scope.init();

        $scope.selectedArea = $scope.formData.event_area[id];
        $scope.selectedCategory = $scope.formData.event_category[id];

        var items = [];
        for(var i =0;i<$scope.formData.no_of_days[id];i++){
            items.push(i);
        }
        $scope.days = items;

        $scope.ok = function () {
        $modalInstance.close($scope.id);
    };

    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
    };
});
