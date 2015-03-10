'use strict';

/**
 * @ngdoc function
 * @name shoutApp.controller:adminViewEventController
 * @description
 * # adminViewEventController
 * Controller of the shoutApp
 */
angular.module('shoutApp')
  .controller('adminViewEventController', function ($scope, $rootScope, adminTaskFactory, $modal, $log, $window) {
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
        $scope.formData.event_city = [];
        $scope.formData.event_location = [];
        $scope.formData.image = [];
        $scope.formData.datetime = [];
        $scope.formData.result_length = [];
        $scope.formData.no_of_days = [];
        $scope.formData.event_organizer_id = [];
        $scope.encoded_image_path_array = [];

      $scope.init = function () {
          adminTaskFactory.getAllEvents().then(function (result) {
              /** Storing the length in
              * result_length so that it can be
               * used in ng-repeat to
               * repeat the loop and create the div
              */


              var k = -1;
              if(result != 'There are no existing events. Please contact the administrator for further enquiry'){
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
                      $scope.formData.event_city[i] = result[i].event_city;
                      $scope.formData.event_location[i] = result[i].event_location;
                      $scope.formData.event_organizer_id = result[i].event_organizer_id;
                      $scope.formData.image[i] = result[i].image;
                      $scope.formData.datetime[i] = result[i].datetime;
                      //    $scope.formData.no_of_days[i] = $scope.formData.datetime[i].length;
                      // getting primary images
                      // using closure to preserve the value of for loop variable
                      // so that for loop does not get executed before promise returns
                      $scope.formData.event_cost[i] = parseInt($scope.formData.event_cost[i]);

                      for(var j = 0;j<$scope.formData.image[i].length;j++){
                          if($scope.formData.image[i][j].primary == 1) {
                              k++;
                              (function(j_alias,k){
                                  adminTaskFactory.loadImages($scope.formData.image[i][j_alias].image_path).then(function(result){
                                      $scope.encoded_image_path_array[k] = result;

                                  })
                              }(j,k))
                          }

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

        //$scope.deleteEvent = function(event_detail_id){
        //    if(confirm("Are you sure you want to delete this event ?"))
        //    {
        //        adminTaskFactory.deleteEvent(event_detail_id).then(function (result) {
        //            console.log(result);
        //            $scope.init();
        //        })
        //    }
        //    else{
        //        return;
        //    }
        //
        //}

        $scope.deleteEventNow = function(event_detail_id){
            swal({
                title: "Are you sure?",
                text: "This Event will be permanently deleted!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "Cancel!",
                closeOnConfirm: false,
                closeOnCancel: false },
                function(isConfirm){
                    if (isConfirm) {
                        adminTaskFactory.deleteEvent(event_detail_id).then(function (result) {
                           // console.log(result);
                            swal("Deleted!", "This Event has been deleted.", "success");
                            $scope.init();
                        })

                    }
                    else {
                        swal("Cancelled", "Phew! The Event wa not deleted", "error");
                    }
                });
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
        //
        //$scope.$on('reloadEventDataInModal', function(event){
        //    $scope.init();
        //    console.log("emmited");
        //})






  })
    /**
     * this is modal controller
     * its variable and scope are available inside
     * the modal only
    */
    .controller('ModalInstanceCtrl', function ($scope, $modalInstance, id, formData, adminTaskFactory, $upload, $rootScope, $timeout, $window) {

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
        $scope.selectedCity = $scope.updatedFormData.event_city[id];
        $scope.selectedCategory = $scope.updatedFormData.event_category[id];
        $scope.updatedFormData.image_encoded_path_array = [];
        $scope.isImageHidden = [];
        $scope.newly_selected_file = [];
        $scope.updated_date_time_array = [];
        $scope.day = '';
        $scope.event_categories = [];
        $scope.event_cities = [];
        $scope.event_areas = [];
        $scope.event_image_id = [];
        $scope.image_path_to_be_deleted = [];
        $scope.isAnyUpdatedFileInvalid = [false,false,false];
        $scope.isAnyUpdatedFileSizeInvalid = [false,false,false];
        $scope.primaryUpdatedImageNotSelected = true
        $scope.isAnyUpdatedFileSelected = [false,false,false];
        $scope.isAnyUpdatedFileExceptPrimaryHasError = false;
        var MAX_FILE_SIZE = 5000000;

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
             *  FIll the city dropdown with initial data
             */
            adminTaskFactory.getEventCity().then(function(result){
                for(var i = 0;i<result.length;i++)
                {
                    $scope.event_cities[i] = result[i][0];
                }
            })

            /* FIll the area dropdown with the intial data */
            adminTaskFactory.getEventArea($scope.selectedCity).then(function(result)
            {
                for(var i = 0;i<result.length;i++)
                {
                    //$scope.event_areas_id[i] = result[i][0];
                    $scope.event_areas[i] = result[i];
                }
            })

            /**
             * get image data url in the image_encoded_path_array
             * so that it can be displayed
             */

           for(var i = 0; i <$scope.updatedFormData.image[id].length; i++){
                    (function(i_alias){
                        adminTaskFactory.loadImages($scope.updatedFormData.image[id][i_alias].image_path).then(function(result){
                            $scope.updatedFormData.image_encoded_path_array[i_alias] = result;
                        })
                    }(i));
           }
        } // end of init function
        $scope.init();

        /**
         * This function is called when city is selected
         * and the area dropdown is filled with the received data
         */

        $scope.getUpdatedEventArea = function(city){
            $scope.event_areas = [];
            adminTaskFactory.getEventArea(city).then(function(result)
            {
                for(var i = 0;i<result.length;i++)
                {
                    //$scope.event_areas_id[i] = result[i][0];
                    $scope.event_areas[i] = result[i];
                }
            })

        }


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

        $scope.handleSelectedFile = function(file_to_be_uploaded, file_id, file_id_to_be_changed, path_to_be_deleted) {

            $scope.newly_selected_file[file_id] = file_to_be_uploaded[0].name;
            $scope.isImageHidden[file_id] = true;
            $scope.event_image_id[file_id] = file_id_to_be_changed;
            $scope.image_path_to_be_deleted[file_id] = path_to_be_deleted;


            $scope.isAnyUpdatedFileSelected[file_id] = true;

            if(file_id == 0)
            {
                $scope.primaryUpdatedImageNotSelected = false;
            }


            if(file_to_be_uploaded[0].type == 'image/png' || file_to_be_uploaded[0].type == 'image/jpeg')
            {
                $scope.isAnyUpdatedFileInvalid[file_id] = false;
            }
            else
            {
                $scope.isAnyUpdatedFileInvalid[file_id] = true;
            }

            if(file_to_be_uploaded[0].size<MAX_FILE_SIZE)
            {
                $scope.isAnyUpdatedFileSizeInvalid[file_id] = false;
            }
            else
            {
                $scope.isAnyUpdatedFileSizeInvalid[file_id] = true;
            }

            if( $scope.isAnyUpdatedFileInvalid[1] || $scope.isAnyUpdatedFileInvalid[2] || $scope.isAnyUpdatedFileSizeInvalid[1] || $scope.isAnyUpdatedFileSizeInvalid[2])
            {
                $scope.isAnyUpdatedFileExceptPrimaryHasError = true;
            }
            else
            {
                $scope.isAnyUpdatedFileExceptPrimaryHasError = false;

            }

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
            $scope.modalFormData.event_detail_id = $scope.updatedFormData.event_detail_id[id];
            $scope.modalFormData.event_name = $scope.updatedFormData.event_name[id];
            $scope.modalFormData.event_category = $scope.selectedCategory;
            $scope.modalFormData.event_cost = $scope.updatedFormData.event_cost[id];
            $scope.modalFormData.event_overview = $scope.updatedFormData.event_overview[id];
            $scope.modalFormData.hash1 = $scope.updatedFormData.event_hashtags[id][0];
            $scope.modalFormData.hash2 = $scope.updatedFormData.event_hashtags[id][1];
            $scope.modalFormData.hash3 = $scope.updatedFormData.event_hashtags[id][2];
            $scope.modalFormData.venue_name = $scope.updatedFormData.venue_name[id];
            $scope.modalFormData.event_area = $scope.selectedArea[0];
            $scope.modalFormData.event_location = $scope.updatedFormData.event_location[id];
            $scope.modalFormData.change_event_schedule_flag = $scope.change_event_schedule_flag;
            $scope.modalFormData.repeatEventCheckbox = $scope.updatedFormData.repeatEventCheckbox;
            $scope.modalFormData.no_of_weeks = $scope.updatedFormData.no_of_weeks;
            $scope.modalFormData.no_of_months = $scope.updatedFormData.no_of_months;
            $scope.modalFormData.repeatType = $scope.updatedFormData.repeatType;
            $scope.modalFormData.event_organizer_id = 1; //$scope.updatedFormData.event_organizer_id[id];

            if($scope.modalFormData.change_event_schedule_flag) {
                $scope.getDateTime();
                $scope.modalFormData.updated_date_time_array = $scope.updated_date_time_array;

            }

            adminTaskFactory.updateEventDetails($scope.modalFormData).then(function(result){

                if(result['status']==='success')
                {
                    /**
                     * upload the images once the form with remaining
                     * fields have been entered into the database
                     */
                    $scope.uploadImages();
                    angular.element('#form-submit-message-placeholder').empty();
                    angular.element('#form-submit-message-placeholder').append('<div id="form-submit-message" class="alert alert-success" style="text-align: center;">Event Updated successfully !! You can view this event in the View Events Tab.</div>');
                    $timeout(function()
                    {
                        angular.element('#form-submit-message-placeholder').empty();
                        $modalInstance.close($scope.id);
                      //  $window.$rootScope.$emit('reloadEventDataInModal');
                        $scope.resetFormAndClearFormModelData();

                    },2000);



                }
                else
                {
                    angular.element('#form-submit-message-placeholder').empty();
                    angular.element('#form-submit-message-placeholder').append('<div id="form-submit-message" class="alert alert-danger" style="text-align: center;">There was some problem in saving the event data. Please try again or contact the administrator.</div>');
                    $timeout(function()
                    {
                        angular.element('#form-submit-message-placeholder').empty();
                    },3000);

                }

            })


            $scope.uploadImages = function() {

                for(var i = 0;i<$scope.event_image_id.length;i++) {
                    if($scope.event_image_id[i]!= undefined){
                        var file = $scope.updatedFormData.images[i];
                        console.log($scope.image_path_to_be_deleted[i]);
                        $upload.upload({
                            url: $rootScope.baseUrl +'/server/adminController.php?func=uploadUpdatedImages&event_image_id='+$scope.event_image_id[i]+'&image_path_old='+$scope.image_path_to_be_deleted[i],
                            method: 'POST',
                            data: file,
                            file: file

                        }).progress(function(evt) {
                            console.log('progress: ' + parseInt(100.0 * evt.loaded / evt.total) + '% file :'+ evt.config.file.name);
                        }).success(function(data, status, headers, config) {
                            console.log('File ' + config.file.name + ' is  uploaded successfully. Response: ' + data);
                        }).error(function(error){
                            console.log(error.message);
                        });
                    }

                }


            }

            $scope.resetFormAndClearFormModelData = function()
            {
                $window.location.reload();
            }

            /**
             * close the modal only after database has been updated
             * */





        };
});
