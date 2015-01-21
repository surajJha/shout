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



            modalInstance.result.then(function (selectedItem) {
                $scope.selected = selectedItem;
            }, function () {
                $log.info('Modal dismissed at: ' + new Date());
            });
        };






  })
    /**
     * this is modal controller
     * its variable and scope are available inside
     * the modal only
    */
    .controller('ModalInstanceCtrl', function ($scope, $modalInstance, id, formData, adminTaskFactory) {
        $scope.event_categories = [];
        $scope.event_areas = [];
        $scope.formData = formData;
        $scope.id = id;
        $scope.formData.datetime_edit = formData.datetime;
        $scope.change_event_schedule_flag = false;
        $scope.selectedArea = $scope.formData.event_area[id];
        $scope.selectedCategory = $scope.formData.event_category[id];
        $scope.formData.image_encoded_path_array = [];
        $scope.isImageHidden = [];
        $scope.newly_selected_file = [];

        $scope.modalFormData = {};



         //
        // console.log(formData);
        /**
         * Init function will be called as soon as the
         * page loads to initialize required params
         */
        $scope.init = function() {

            /**
             * loadImages is called when modal
             * is opened, to give preview of
             * the images.
             * written thrice because it was not working in
             * for loop
             */
            adminTaskFactory.loadImages($scope.formData.image[id][0].image_path).then(function(result){
                $scope.formData.image_encoded_path_array[0] = result;
            })
            adminTaskFactory.loadImages($scope.formData.image[id][1].image_path).then(function(result){
                $scope.formData.image_encoded_path_array[1] = result;
            })
            adminTaskFactory.loadImages($scope.formData.image[id][2].image_path).then(function(result){
                $scope.formData.image_encoded_path_array[2] = result;
            })


            //for(var i=0;i<$scope.formData.image[id].length;i++) {
            //    console.log(i);
            //    adminTaskFactory.loadImages($scope.formData.image[id][i].image_path).then(function(result){
            //        console.log(i);
            //        $scope.formData.image_encoded_path_array[i] = result;
            //        console.log("i = "+i+" data = "+$scope.formData.image_encoded_path_array[i]);
            //    })
            //}

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


        /**
         * Funtion handles the file change in the modal
         * it shows the name of the newly selected file
         * and removes the thumbnail of the previous file
         * the previous file will be deleted only when
         * the modal form will be submitted
         */

        $scope.handleSelectedFile = function(file_to_be_uploaded, file_id) {

            $scope.newly_selected_file[file_id] = file_to_be_uploaded[0].name;
            console.log( $scope.newly_selected_file[file_id]);
            $scope.isImageHidden[file_id] = true;

        }

        var items = [];
        for(var i =0;i<$scope.formData.no_of_days[id];i++){
            items.push(i);
        }
        $scope.days = items;



    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
    };

        $scope.updateEventDetails = function () {
            $scope.modalFormData.event_detail_id = $scope.formData.event_detail_id[id];
            $scope.modalFormData.event_name = $scope.formData.event_name[id];
            $scope.modalFormData.event_category = $scope.selectedCategory;
            $scope.modalFormData.event_cost = $scope.formData.event_cost[id];
            $scope.modalFormData.event_overview = $scope.formData.event_overview[id];
            $scope.modalFormData.hash1 = $scope.formData.event_hashtags[id][0];
            $scope.modalFormData.hash2 = $scope.formData.event_hashtags[id][1];
            $scope.modalFormData.hash3 = $scope.formData.event_hashtags[id][2];
            $scope.modalFormData.venue_name = $scope.formData.venue_name[id];
            $scope.modalFormData.event_area = $scope.selectedArea;
            $scope.modalFormData.event_location = $scope.formData.event_location[id];
            $scope.modalFormData.change_event_schedule_flag = $scope.change_event_schedule_flag;

            //$scope.modalFormData.no_of_days = $scope.formData.no_of_days[id];
            //$scope.modalFormData.repeatEventCheckbox = $scope.formData.repeatEventCheckbox[id];
            //$scope.modalFormData.no_of_weeks = $scope.formData.no_of_weeks[id];
            //$scope.modalFormData.no_of_months = $scope.formData.no_of_months[id];
            //$scope.modalFormData.repeatType = $scope.formData.repeatType[id];
            //$scope.modalFormData.images = [];
            //$scope.modalFormData.datetime = [];


            adminTaskFactory.updateEventDetails($scope.modalFormData).then(function(result){
                console.log(result);
            })
            /**
             * close the modal only after database has been updated
             * */
            console.log($scope.modalFormData);



             $modalInstance.close($scope.id);
        };
});
