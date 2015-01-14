'use strict';

/**
 * @ngdoc function
 * @name shoutApp.controller:adminAddEventController
 * @description
 * # adminAddEventController
 * Controller of the shoutApp
 */
angular.module('shoutApp')
  .controller('adminAddEventController', function ($scope, $rootScope, $upload, adminTaskFactory) {
        /**
         * declaring all global variables for
         * this controller
         */
        /**
         *
         * @type {{}}
         *  formData object will hold all the data from the add event form
         * i.e will act as the model for the form
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
        $scope.formData.images = [];
        $scope.formData.datetime = [];

        /**
         * ========================================================
         */


        /**
         * the generateDatepicker function generates the datepicker
         * widget as per the value of dropdown
         * this function is associated only with the dropdown
         */
        var generateDatepicker = (function () {
            $scope.days = [1,2,3,4,5,6,7];
            $scope.day = $scope.days[0];
            $scope.change = function (no_of_days) {
                $scope.day = no_of_days;
            }
        })();
        /**
         * get date and time fields of the dynamically
         * generated date fields and push it to the
         * model varaibles
         */
        $scope.getDateTime = function () {
            for(var i = 0; i< $scope.day; i++){
                $scope.formData.datetime.push({date: $('#dt-'+i).val(), starttime: $('#time1-'+i).html(), endtime: $('#time2-'+i).html()})
            }
        }
        /**
         * submit event form func will be called when submit
         * button will be pressed on the form
         */
        $scope.submitEventForm = function () {
          $scope.getDateTime();
         adminTaskFactory.addNewEvent($scope.formData).then(function(result){
             console.log(result);
             // for successful insertion into the database
             // the result returned should bt "success"
                if(result['status']==='success') {
                    /**
                     * upload the images once the form with remaining
                     * fields have been entered into the database
                     */
                   // console.log('result is '+result);
                    $scope.uploadImages(result['organiser_id']);

                }
            });
        }

        $scope.uploadImages = function(organiser_id) {

            for(var i = 0;i<$scope.formData.images.length;i++) {
                var file = $scope.formData.images[i];
                $upload.upload({
                    url: $rootScope.baseUrl +'/server/adminController.php?func=uploadImages&organiser_id='+organiser_id,
                    headers: {'Content-Type': file.type},
                    method: 'POST',
                    data: file,
                    file: file

                }).progress(function(evt) {


                   console.log('progress: ' + parseInt(100.0 * evt.loaded / evt.total) + '% file :'+ evt.config.file.name);
                }).success(function(data, status, headers, config) {

                    console.log('File ' + config.file.name + ' is  uploaded successfully. Response: ' + data);
                }).error(function(error){
                    console.log(error);
                });
            }


        }


    });
