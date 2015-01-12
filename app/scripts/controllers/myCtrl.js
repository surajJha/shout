/**
 * Created by root on 12/1/15.
 */


angular.module('shoutApp')
    .controller('MyCtrl', ['$scope', '$upload', '$rootScope', function ($scope, $upload, $rootScope) {
        $scope.myFiles = [];
        $scope.$watch('myFiles', function() {
            for (var i = 0; i < $scope.myFiles.length; i++) {
                var file = $scope.myFiles[i];
                $scope.upload = $upload.upload({
                    url: $rootScope.baseUrl +'/server/rest.php&f=getDetails',
                    headers: {'Content-Type': file.type},
                    method: 'POST',
                    data: file,
                    file: file

                }).progress(function(evt) {
                    console.log('progress: ' + parseInt(100.0 * evt.loaded / evt.total) + '% file :'+ evt.config.file.name);
                }).success(function(data, status, headers, config) {

                    console.log('file ' + config.file.name + 'is  uploaded successfully. Response: ' + data);
                }).error(function(error){
                    console.log(error);
                });

            }


        });

    }]);
