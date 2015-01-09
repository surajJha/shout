'use strict';

describe('Service: adminTaskFactory', function () {

  // load the service's module
  beforeEach(module('shoutApp'));

  // instantiate service
  var adminTaskFactory;
  var mock
  beforeEach(inject(function (_adminTaskFactory_) {
    adminTaskFactory = _adminTaskFactory_;
  }));

  it('should do something', function () {
    expect(!!adminTaskFactory).toBe(true);
   // expect(adminTaskFactory.getAllEvents()).toEqual(2);
   // expect(adminTaskFactory.arr.length).toBe(3);
   // expect(adminTaskFactory.getAllEvents()).toBe('2');
  });

});

