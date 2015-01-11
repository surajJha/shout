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

                  /** Making opened a array
                   * this will be used to create different calender
                   */
                  scope.opened = [];
                  scope.open = function($event, id) {
                      $event.preventDefault();
                      $event.stopPropagation();

                      scope.opened[id] = true;
                  };

                  scope.dateOptions = {
                      formatYear: 'yy',
                      startingDay: 1
                  };

                  scope.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
                  scope.format = scope.formats[0];

                  /* Timepicker Angularjs javascript */

                  scope.mytime1 = new Date();
                  scope.mytime2 = new Date();

                  scope.hstep = 1;
                  scope.mstep = 15;

                  scope.ismeridian = true;
                  //scope.toggleMode = function() {
                  //    scope.ismeridian = ! scope.ismeridian;
                  //};

                  //scope.update = function() {
                  //    var d = new Date();
                  //    d.setHours( 14 );
                  //    d.setMinutes( 0 );
                  //    scope.mytime = d;
                  //};

                  

                  newvalue = parseInt(newvalue);
                  //add the number of days in array items in order to loop through it in ng-repeat
                  var items = [];
                  for(var i =0;i<newvalue;i++){
                      items.push(i);
                  }
                  scope.items = items;

                  // this is to empty the div if the no of days is changed
                  angular.element(document.getElementById('datepicker-placeholder')).html('');

                  var template = '<div ng-repeat="i in items track by $index"><div class="row"><div class="col-md-6" style="margin-top: 34px;"><p class="input-group"> <input type="text" class="form-control" datepicker-popup="{{format}}" ng-model="dt" is-open="opened[\'dt-\'+$index]" min-date="minDate" max-date="\'2015-06-22\'" datepicker-options="dateOptions" date-disabled="disabled(date, mode)" ng-required="true" close-text="Close" id="dt-{{$index}}" /> <span class="input-group-btn"> <button type="button" class="btn btn-default" ng-click="open($event, \'dt-\'+$index)"><i class="glyphicon glyphicon-calendar"></i></button> </span> </p> </div><div class="col-md-3"><timepicker ng-model="mytime1" hour-step="hstep" minute-step="mstep" show-meridian="ismeridian"></timepicker></div><div class="col-md-3"><div id="time1-{{$index}}" ng-hide="true">{{mytime1 | date:\'shortTime\' }}</div><timepicker ng-model="mytime2" id="time2-{{$index}}" hour-step="hstep" minute-step="mstep" show-meridian="ismeridian"></timepicker><div id="time2-{{$index}}" ng-hide="true">{{mytime2 | date:\'shortTime\' }}</div></div></div></div>';

                  angular.element(document.getElementById('datepicker-placeholder')).append($compile(template)(scope));
              }
          },true)
      }
    };
  });
