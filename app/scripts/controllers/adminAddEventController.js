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
        $scope.formData.image1 = '';
        $scope.formData.image2 = '';
        $scope.formData.image3 = '';
        $scope.formData.datetime = [];
        //$scope.formData.datetime.dt = [];
        //$scope.formData.datetime.mytime1 = [];
        //$scope.formData.datetime.mytime2 = [];
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

        $scope.submitEventForm = function () {
          $scope.getDateTime();
            adminTaskFactory.addNewEvent($scope.formData,function(result){
                console.log("result returned"+result);
            });
        }

        $scope.image1 = "";
        $scope.image2 = "";
        $scope.image3 = "";


        $scope.$watch('image1', function() {

            var file = $scope.image1;
            $scope.upload = $upload.upload({
                url: $rootScope.baseUrl +'/server/rest.php?f=saveImage',
                headers: {'Content-Type': file.type},
                method: 'POST',
                data: file,
                file: file

            });
            //    .progress(function(evt) {
            //    console.log('progress: ' + parseInt(100.0 * evt.loaded / evt.total) + '% file :'+ evt.config.file.name);
            //})
            //    .success(function(data, status, headers, config) {
            //
            //        console.log('File ' + config.file.name + ' is  uploaded successfully. Response: ' + data);
            //    }).error(function(error){
            //        console.log(error);
            //    });




        });

        $scope.$watch('image2', function() {

            var file = $scope.image2;
            $scope.upload = $upload.upload({
                url: $rootScope.baseUrl +'/server/rest.php?f=saveImage',
                headers: {'Content-Type': file.type},
                method: 'POST',
                data: file,
                file: file

            });
            //.progress(function(evt) {
            //    console.log('progress: ' + parseInt(100.0 * evt.loaded / evt.total) + '% file :'+ evt.config.file.name);
            //})
            //.success(function(data, status, headers, config) {
            //
            //    console.log('File ' + config.file.name + ' is  uploaded successfully. Response: ' + data);
            //}).error(function(error){
            //    console.log(error);
            //});

        });

        $scope.$watch('image3', function() {

            var file = $scope.image3;
            $scope.upload = $upload.upload({
                url: $rootScope.baseUrl +'/server/rest.php?f=saveImage',
                headers: {'Content-Type': file.type},
                method: 'POST',
                data: file,
                file: file

            });
            //.progress(function(evt) {
            //    console.log('progress: ' + parseInt(100.0 * evt.loaded / evt.total) + '% file :'+ evt.config.file.name);
            //})
            //.success(function(data, status, headers, config) {
            //
            //    console.log('File ' + config.file.name + ' is  uploaded successfully. Response: ' + data);
            //}).error(function(error){
            //    console.log(error);
            //});

        });

    });
