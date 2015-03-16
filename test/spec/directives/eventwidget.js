'use strict';

describe('Directive: eventwidget', function () {

  // load the directive's module
  beforeEach(module('shoutApp'));

  var element,
    scope;

  beforeEach(inject(function ($rootScope) {
    scope = $rootScope.$new();
  }));

  it('should make hidden element visible', inject(function ($compile) {
    element = angular.element('<eventwidget></eventwidget>');
    element = $compile(element)(scope);
    expect(element.text()).toBe('this is the eventwidget directive');
  }));
});
