'use strict';

describe('Controller: adminAddEventController', function () {

  // load the controller's module
  beforeEach(module('shoutApp'));

  var adminAddEventController,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
      adminAddEventController = $controller('adminAddEventController', {
      $scope: scope
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {

  });
});