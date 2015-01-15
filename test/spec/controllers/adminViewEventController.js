'use strict';

describe('Controller: adminViewEventController', function () {

  // load the controller's module
  beforeEach(module('shoutApp'));

  var adminViewEventController,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
      adminViewEventController = $controller('adminViewEventController', {
      $scope: scope
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(scope.awesomeThings.length).toBe(3);
  });
});
