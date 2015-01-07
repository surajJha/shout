'use strict';

describe('Controller: adminHomeController', function () {

  // load the controller's module
  beforeEach(module('shoutApp'));

  var adminHomeController,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    adminHomeController = $controller('adminHomeController', {
      $scope: scope
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    //expect(scope.awesomeThings.length).toBe(3);
    expect(scope.one).toBeDefined();

  });

  it('changename function needs to be defined to be used', function () {
    expect(scope.changeName).toBeDefined();
  })

});
