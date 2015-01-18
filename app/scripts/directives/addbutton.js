///**
// * Created by Neha on 1/18/2015.
// */
////Directive that returns an element which adds buttons on click which show an alert on click
//angular.module('shoutApp')
//    .directive("addbuttonsbutton", function(){
//    return {
//        restrict: "E",
//        template: "<div addbuttons class ='viewEvents'><div class='row eventTitle'>EVENT NAME </div><div class='row eventDetails'><div class='col-lg-4'>ADDRESS<br>PRICE : 400/-</div><div class='col-lg-4'></div><div class='col-lg-4' id='options'></div></div></div>"
//    }
//});
//
////Directive for adding buttons on click that show an alert on click
//angular.module('shoutApp')
//.directive("addbuttons", function($compile){
//    return function(scope, element, attrs){
//        element.bind("click", function(){
//            angular.element(document.getElementById('options')).append($compile("<div><button class='btn btn-primary' id='edit'>Edit</button></div>")(scope));
//        });
//
//        element.bind("mouseout", function($complie){
//            angular.element(document.getElementById('edit')).remove();
//        });
//    };
//});