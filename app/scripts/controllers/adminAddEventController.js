'use strict';

/**
 * @ngdoc function
 * @name shoutApp.controller:adminAddEventController
 * @description
 * # adminAddEventController
 * Controller of the shoutApp
 */
angular.module('shoutApp')
  .controller('adminAddEventController', function ($scope, $rootScope, $upload, adminTaskFactory, $timeout, $window) {
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
        $scope.formData.no_of_days = '';
        $scope.formData.repeatEventCheckbox = '';
        $scope.formData.no_of_weeks = '';
        $scope.formData.no_of_months = '';
        $scope.formData.repeatType = '';
        $scope.formData.images = [];
        $scope.formData.datetime = [];
        $scope.event_categories = [];
        $scope.event_areas = [];
        $scope.selectedFile = [];
        $scope.isAnyFileInvalid = [true,false,false];
        $scope.isAnyFileSizeInvalid = [true,false,false];
        $scope.primaryImageNotSelected = true
        $scope.isAnyFileSelected = [false,false,false];
        $scope.isAnyFileExceptPrimaryHasError = false;
        var MAX_FILE_SIZE = 5000000;





        /**
         * ========================================================
         */
        /**
         * Init function will be called as soon as the
         * page loads to initialize required params.
         * 1. FIll the category dropdown with initial data
         * 2. FIll the area dropdown with initial data
         */
        $scope.init = function()
        {
            adminTaskFactory.getEventCategory().then(function (result)
            {
                for(var i = 0;i<result.length;i++)
                {
                    $scope.event_categories[i] = result[i][0];
                }

            });
            adminTaskFactory.getEventArea().then(function(result)
            {
                 for(var i = 0;i<result.length;i++)
                 {
                     $scope.event_areas[i] = result[i][0];
                 }
             })
        }
        $scope.init();


        /**
         * the generateDatepicker function generates the datepicker
         * widget as per the value of dropdown
         * this function is associated only with the dropdown
         */
          /** $scope.day is used to store the number of days selected in dropdown
           * $scope.day = $scope.days[0]; this stores the first value by default
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
          //  console.log('inside contr');
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
                   $scope.uploadImages(result['organiser_id'],result['event_detail_id']);
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

        $scope.uploadImages = function(organiser_id, event_detail_id)
        {

            for(var i = 0;i<$scope.formData.images.length;i++)
            {
                var primary_image =0;
                if(i == 0)primary_image=1;
                var file = $scope.formData.images[i];
                $upload.upload({
                    url: $rootScope.baseUrl +'/server/adminController.php?func=uploadImages&organiser_id='+organiser_id+'&event_detail_id='+event_detail_id+'&primary_image='+primary_image,
                    method: 'POST',
                    data: file,
                    file: file

                }).progress(function(evt) {

                }).success(function(data, status, headers, config) {


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
