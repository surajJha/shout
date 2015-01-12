/**
 * Created by root on 12/1/15.
 */


angular.module('shoutApp')
    .controller('MyCtrl', function ($scope, $upload, $rootScope) {
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
