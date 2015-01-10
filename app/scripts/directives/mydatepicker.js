'use strict';

/**
 * @ngdoc directive
 * @name shoutApp.directive:mydatepicker
 * @description
 * # mydatepicker
 */
angular.module('shoutApp')
  .directive('mydatepicker', function ($compile) {
    return {

      //restrict: 'E',
        transclude: 'element',
        scope:{day:'='},
      link: function (scope, element, attrs) {
          scope.$watch('day',function(newvalue,oldvalue){
              if(newvalue === oldvalue)return;
              else{
                  scope.today = function() {
                      scope.dt = new Date();
                  };
                  scope.today();

                  scope.clear = function () {
                      scope.dt = null;
                  };

                  // Disable weekend selection
                  scope.disabled = function(date, mode) {
                      return ( mode === 'day' && ( date.getDay() === 0 || date.getDay() === 6 ) );
                  };

                  scope.toggleMin = function() {
                      scope.minDate = scope.minDate ? null : new Date();
                  };
                  scope.toggleMin();

                  scope.open = function($event) {
                      $event.preventDefault();
                      $event.stopPropagation();

                      scope.opened = true;
                  };

                  scope.dateOptions = {
                      formatYear: 'yy',
                      startingDay: 1
                  };

                  scope.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
                  scope.format = scope.formats[0];

                  scope.getNumber = function(day) {
                      return new Array(day);
                  }
                  newvalue = parseInt(newvalue);
                  var items = [];
                  for(var i =0;i<newvalue;i++){
                      items.push(i);
                  }
                  scope.items = items;

                  var template = '<div ng-repeat="i in items"><div class="row"><div class="col-md-6"><p class="input-group"> <input type="text" class="form-control" datepicker-popup="{{format}}" ng-model="dt" is-open="opened" min-date="minDate" max-date="\'2015-06-22\'" datepicker-options="dateOptions" date-disabled="disabled(date, mode)" ng-required="true" close-text="Close" /> <span class="input-group-btn"> <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button> </span> </p> </div></div>';

                  angular.element(document.getElementById('datepicker-placeholder')).append($compile(template)(scope));


              }
          },true)
      }
    };
  });
