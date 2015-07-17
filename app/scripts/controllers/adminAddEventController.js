'use strict';

/**
 * @ngdoc function
 * @name shoutApp.controller:adminAddEventController
 * @description
 * # adminAddEventController
 * Controller of the shoutApp
 */
angular.module('shoutApp')
  .controller('adminAddEventController', function ($scope, $rootScope, $upload, adminTaskFactory, $timeout, $window, sessionService) {
        /**
         * declaring all global variables for
         * this controller
         */
        /**
         *
         * @type {{}}
         *  formData object will hold all the data from the add event form
         * i.e will act as the model for the form
         * event_categories, event_areas = the data is retrieved from the database and stored in these variables
         * repeatEventCheckbox these flag is used to check if event is repeated or not
         * repeatType is used to store the type of event --> weekly or monthly
         * selectedFile is used in watch function to store the selected file
         */

        $scope.formData = {};
        $scope.formData.organiser_id = '';
        $scope.formData.event_name = '';
        $scope.formData.event_category = '';
        $scope.formData.event_cost = '';
        $scope.formData.event_overview = '';
        $scope.formData.hash1 = '';
        $scope.formData.hash2 = '';
        $scope.formData.hash3 = '';
        $scope.formData.venue_name = '';
        $scope.formData.event_area = '';
        $scope.formData.event_location = '';
        $scope.formData.event_latitude = '';
        $scope.formData.event_longitude = '';
        $scope.formData.no_of_days = '';
        $scope.formData.repeatEventCheckbox = '';
        $scope.formData.no_of_weeks = '';
        $scope.formData.no_of_months = '';
        $scope.formData.repeatType = '';
        $scope.formData.images = [];
        $scope.formData.datetime = [];
        $scope.event_categories = [];
        $scope.event_areas = [];
        $scope.event_areas_id = [];
        $scope.event_cities = [];
        $scope.selectedFile = [];
        $scope.isAnyFileInvalid = [true,false,false];
        $scope.isAnyFileSizeInvalid = [true,false,false];
        $scope.primaryImageNotSelected = true
        $scope.isAnyFileSelected = [false,false,false];
        $scope.isAnyFileExceptPrimaryHasError = false;
        var MAX_FILE_SIZE = 5000000;

    $("#event_location").on("blur", function(){
        var address = $("#event_location").val();
         $scope.getCoordinates(address);

    })

$scope.getCoordinates = function(address) {
    var geocoder = new google.maps.Geocoder();
    var coord = [];
    geocoder.geocode({address : address} , function(results ,status){
        if(results){
            if(results[0].hasOwnProperty('geometry') && results[0].geometry) {
                $scope.formData.event_latitude =  results[0].geometry.location.A;
                $scope.formData.event_longitude =  results[0].geometry.location.F;
            }
        }
    })
}

        /**
         * ========================================================
         */
        /**
         * Init function will be called as soon as the
         * page loads to initialize required params.
         * 1. FIll the category dropdown with initial data
         * 2. FIll the city dropdown with initial data
         */
        $scope.init = function()
        {
            adminTaskFactory.getEventCategory().then(function (result)
            {
                if(result){
                    for(var i = 0;i<result.length;i++)
                    {
                        $scope.event_categories[i] = result[i][0];
                    }
                }
            });
            adminTaskFactory.getEventCity().then(function(result){
                for(var i = 0;i<result.length;i++)
                {
                    $scope.event_cities[i] = result[i][0];
                }
            })
        }
        $scope.init();

        /**
         * This function is called when city is selected
         * and the area dropdown is filled with the received data
         */

        $scope.getEventArea = function(city){
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
         * the generateDatepicker function generates the datepicker
         * widget as per the value of dropdown
         * this function is associated only with the dropdown
         */
          /** $scope.day is used to store the number of days selected in dropdown
          */
        var generateDatepicker = (function ()
          {
            $scope.days = [1,2,3,4,5,6,7];
            $scope.day = '';
            $scope.change = function (no_of_days)
            {
                $scope.day = no_of_days;
            }
        })();
        /**
         * get date and time fields of the dynamically
         * generated date fields and push it to the
         * model varaibles
         */
        $scope.getDateTime = function ()
        {
            for(var i = 0; i< $scope.day; i++)
            {
                $scope.formData.datetime.push({date: $('#dt-'+i).val(), starttime: $('#time1-'+i).html(), endtime: $('#time2-'+i).html()})

            }
        }
        /**
         * submit event form func will be called when submit
         * button will be pressed on the form
         */
        $scope.submitEventForm = function ()
        {
            $scope.formData.organiser_id = sessionService.get("user");
          $scope.getDateTime();
        adminTaskFactory.addNewEvent($scope.formData).then(function(result)
        {
           /** for successful insertion into the database
            * the result returned should bt "success"
            * */
               if(result['status']==='success')
               {
                  /**
                  * upload the images once the form with remaining
                  * fields have been entered into the database
                    */
                   $scope.uploadImages(result['event_detail_id']);
                   angular.element('#form-submit-message-placeholder').empty();
                   angular.element('#form-submit-message-placeholder').append('<div id="form-submit-message" class="alert alert-success" style="text-align: center;">Event added successfully !! You can view this event in the View Events Tab.</div>');
                   $timeout(function()
                   {
                       angular.element('#form-submit-message-placeholder').empty();
                       $scope.resetFormAndClearFormModelData();

                   },3000);



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
          });
        }

        $scope.uploadImages = function(event_detail_id)
        {
            for(var i = 0;i<$scope.formData.images.length;i++)
            {
                var primary_image =0;
                if(i == 0)primary_image=1;
                var file = $scope.formData.images[i];
                $upload.upload({
                    url: $rootScope.baseUrl +'/server/adminController.php?func=uploadImages&event_detail_id='+event_detail_id+'&organiser_id='+$scope.formData.organiser_id+'&primary_image='+primary_image,
                method: 'POST',
                    data: file,
                    file: file

                }).progress(function(evt) {

                }).success(function(data, status, headers, config) {
                    var last_inserted_image_id = data.image_id;

                    $upload.upload({
                        url: $rootScope.baseUrl +'/server/resizeImageAndroid.php?event_image_id='+last_inserted_image_id,
                        method: 'POST',
                        data: file,
                        file: file

                    }).progress(function(evt) {

                    }).success(function(data, status, headers, config) {

                    }).error(function(error){
                        console.log(error.message);
                    });
                }).error(function(error){
                    console.log(error.message);
                });

            }


        }

        /**
         * watch for file change and show the names and preview thumbnail
         * also check if the file is a valid image file or not
         * If it is not a valid image file then set the isAnyFileInvalid
         * flag to true. Use this flag during form validation(to disable/enable
         * the submit button)
         */
        $scope.fileChanged = function(file_to_be_uploaded, file_id)
        {

            $scope.isAnyFileSelected[file_id] = true;
             $scope.selectedFile[file_id] = file_to_be_uploaded[0].name;
            if(file_id == 0)
            {
                $scope.primaryImageNotSelected = false;
            }


            if(file_to_be_uploaded[0].type == 'image/png' || file_to_be_uploaded[0].type == 'image/jpeg')
            {
                $scope.isAnyFileInvalid[file_id] = false;
            }
            else
            {
                $scope.isAnyFileInvalid[file_id] = true;
            }

            if(file_to_be_uploaded[0].size<MAX_FILE_SIZE)
            {
                $scope.isAnyFileSizeInvalid[file_id] = false;
            }
            else
            {
                $scope.isAnyFileSizeInvalid[file_id] = true;
            }

            if( $scope.isAnyFileInvalid[1] || $scope.isAnyFileInvalid[2] || $scope.isAnyFileSizeInvalid[1] || $scope.isAnyFileSizeInvalid[2])
            {
                $scope.isAnyFileExceptPrimaryHasError = true;
            }
            else
            {
                $scope.isAnyFileExceptPrimaryHasError = false;

            }


        }
        /**
         * Reset form and clear all the models attached to the input fields
         */
        $scope.resetFormAndClearFormModelData = function()
        {
            $window.location.reload();
        }

    });
