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
                  scope.dt = [];
                  scope.today = function() {
                      scope.dt[0] = new Date();
                  };
                  scope.today();

                  //scope.clear = function () {
                  //    scope.dt = null;
                  //};

                  // Disable weekend selection
                  //scope.disabled = function(date, mode) {
                  //    return ( mode === 'day' && ( date.getDay() === 0 || date.getDay() === 6 ) );
                  //};

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
                  scope.format = scope.formats[1];

                  /* Timepicker Angularjs javascript */

                  scope.starttime = 0 ; new Date();
                  scope.endtime = new Date();

                  scope.hstep = 1;
                  scope.mstep = 15;

                  scope.ismeridian = false;
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

                  var template = '<div ng-repeat="i in items track by $index"><div class="row"><div class="col-md-6" style="margin-top: 34px;"><p class="input-group"> <input type="text" class="form-control" datepicker-popup="{{format}}" ng-model="formData.datetime.dt[\'{{$index}}\']" is-open="opened[\'dt-\'+$index]" min-date="minDate" datepicker-options="dateOptions"  ng-required="true" close-text="Close" id="dt-{{$index}}" /> <span class="input-group-btn"> <button type="button" class="btn btn-default" ng-click="open($event, \'dt-\'+$index)"><i class="glyphicon glyphicon-calendar"></i></button> </span> </p> </div><div class="col-md-3"><timepicker ng-model="starttime" hour-step="hstep" minute-step="mstep" show-meridian="ismeridian"></timepicker><div id="time1-{{$index}}" ng-hide="true">{{starttime | date:\'HH:mm\' }}</div></div><div class="col-md-3"><timepicker ng-model="endtime" hour-step="hstep" minute-step="mstep" show-meridian="ismeridian"></timepicker><div id="time2-{{$index}}" ng-hide="true">{{endtime | date:\'HH:mm\' }}</div></div></div></div>';

                  angular.element(document.getElementById('datepicker-placeholder')).append($compile(template)(scope));
              }
          },true)
      }
    };
  });
