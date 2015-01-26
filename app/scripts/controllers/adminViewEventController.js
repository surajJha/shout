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
        /**
         * formData is an object which stores the result retreive from
         * database from function getAllEvents
         * @type {{}}
         */
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
        $scope.encoded_image_path_array = [];

      $scope.init = function () {
          var organiser_id = 1; //change to sessionid afterwards
          adminTaskFactory.getAllEvents(organiser_id).then(function (result) {

            //  console.log(result);

              /** Storing the length in
              * result_length so that it can be
               * used in ng-repeat to
               * repeat the loop and create the div
              */
                $scope.makeArray(result);

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
                  // getting primary images
                  // using closure to preserve the value of for loop variable
                  // so that for loop does not get executed before promise returns
                for(var j = 0;j<$scope.formData.image[i].length;j++){
                    if($scope.formData.image[i][j].primary == 1) {
                        (function(j_alias){
                            adminTaskFactory.loadImages($scope.formData.image[i][j_alias].image_path).then(function(result){
                                //  console.log(result);
                                $scope.encoded_image_path_array[j_alias] = result;

                             //   console.log(j_alias)

                            })
                        }(j))
                    }

                }



              }


          }); //getallevents func ends here
      }
        $scope.init();

        $scope.makeArray = function(result){
            var items = [];
            for(var i =0;i<result.length;i++){
                items.push(i);
            }
            $scope.formData.result_length = items;
        }


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

        /**updatedFormData is and object, and it stores the data received when the modal is opened
         * this object is available in the scope of the modal
         * selectedArea, selectedCategory is used to display the araa and category
         * in the dropdown as selected attribute
         * newly_selected_file used to keep track of the file changed in modal
         * updated_date_time_array is used to store the datetime of the modal if changed
         * $scope.day is used to store the number of days selected in dropdown
         */

        $scope.updatedFormData = formData;
        $scope.id = id;
        $scope.updatedFormData.datetime_edit = formData.datetime;
        $scope.change_event_schedule_flag = false;
        $scope.selectedArea = $scope.updatedFormData.event_area[id];
        $scope.selectedCategory = $scope.updatedFormData.event_category[id];
        $scope.updatedFormData.image_encoded_path_array = [];
        $scope.isImageHidden = [];
        $scope.newly_selected_file = [];
        $scope.updated_date_time_array = [];
        $scope.day = '';
        $scope.event_categories = [];
        $scope.event_areas = [];
        $scope.updatedFormData.changedImageFileId = [];

        $scope.modalFormData = {};

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
                for(var i = 0;i<result.length;i++){
                    $scope.event_areas[i] = result[i][0];
                }
            })

            /**
             * get image data url in the image_encoded_path_array
             * so that it can be displayed
             */
           for(var i = 0; i <$scope.updatedFormData.image[id].length; i++){
                    (function(i_alias){
                        adminTaskFactory.loadImages($scope.updatedFormData.image[id][i_alias].image_path).then(function(result){
                          //  console.log(result);
                            $scope.updatedFormData.image_encoded_path_array[i_alias] = result;

                          //  console.log(i_alias)
                        })
                    }(i));
           }
        } // end of init function
        $scope.init();

        /**
         * get date and time fields of the dynamically
         * generated date fields and push it to the
         * model varaibles
         */
        $scope.getDateTime = function () {
            for(var i = 0; i< $scope.day; i++){
                $scope.updated_date_time_array.push({date: $('#dt-'+i).val(), starttime: $('#time1-'+i).html(), endtime: $('#time2-'+i).html()})

            }
        }


        /**
         * Funtion handles the file change in the modal
         * it shows the name of the newly selected file
         * and removes the thumbnail of the previous file
         * the previous file will be deleted only when
         * the modal form will be submitted
         */

        $scope.handleSelectedFile = function(file_to_be_uploaded, file_id, event_image_id) {
          //  console.log(event_image_details);
            $scope.newly_selected_file[file_id] = file_to_be_uploaded[0].name;
            $scope.isImageHidden[file_id] = true;
            $scope.updatedFormData.changedImageFileId[file_id] = event_image_id;

        }

        /** makeArrayForDays() is used to convert string in array
         * this will be used in ng-repeat in modal to display the schedule
         */


        $scope.makeArrayForDays = function(){
            var items = [];
            for(var i =0;i<$scope.updatedFormData.no_of_days[id];i++){
                items.push(i);
            }
            $scope.countDays = items;
        }

        $scope.makeArrayForDays();

    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
    };

        $scope.updateEventDetails = function () {
           // console.log($scope.updatedFormData);
            $scope.modalFormData.event_detail_id = $scope.updatedFormData.event_detail_id[id];
            $scope.modalFormData.event_name = $scope.updatedFormData.event_name[id];
            $scope.modalFormData.event_category = $scope.selectedCategory;
            $scope.modalFormData.event_cost = $scope.updatedFormData.event_cost[id];
            $scope.modalFormData.event_overview = $scope.updatedFormData.event_overview[id];
            $scope.modalFormData.hash1 = $scope.updatedFormData.event_hashtags[id][0];
            $scope.modalFormData.hash2 = $scope.updatedFormData.event_hashtags[id][1];
            $scope.modalFormData.hash3 = $scope.updatedFormData.event_hashtags[id][2];
            $scope.modalFormData.venue_name = $scope.updatedFormData.venue_name[id];
            $scope.modalFormData.event_area = $scope.selectedArea;
            $scope.modalFormData.event_location = $scope.updatedFormData.event_location[id];
            $scope.modalFormData.change_event_schedule_flag = $scope.change_event_schedule_flag;
            $scope.modalFormData.repeatEventCheckbox = $scope.updatedFormData.repeatEventCheckbox;
            $scope.modalFormData.no_of_weeks = $scope.updatedFormData.no_of_weeks;
            $scope.modalFormData.no_of_months = $scope.updatedFormData.no_of_months;
            $scope.modalFormData.repeatType = $scope.updatedFormData.repeatType;
            $scope.modalFormData.image = $scope.updatedFormData.image[id];
            $scope.modalFormData.changedImageFileId = $scope.updatedFormData.changedImageFileId;
            $scope.modalFormData.newly_selected_file = $scope.newly_selected_file;

         //   console.log($scope.modalFormData.changedImageDetails);

         //   console.log($scope.modalFormData.changedImageDetails[1] == '' );


            if($scope.modalFormData.change_event_schedule_flag) {
                $scope.getDateTime();
                $scope.modalFormData.updated_date_time_array = $scope.updated_date_time_array;

            }


            adminTaskFactory.updateEventDetails($scope.modalFormData).then(function(result){
                console.log("final output = "+result);
            })
            /**
             * close the modal only after database has been updated
             * */




             $modalInstance.close($scope.id);
        };
});
