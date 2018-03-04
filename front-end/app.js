var app = angular.module('app', [
  'naif.base64',
  'signature',
  'ui.router',
]);

app.config(function($stateProvider, $urlRouterProvider){
  $urlRouterProvider.otherwise('/');

  var home = {
    name: 'home',
    url: '/',
    component: 'home'
  };
  var profile = {
    name: 'profile',
    url: '/profile/{profileId}',
    component: 'profile'
  };
  var listing = {
    name: 'listing',
    url: '/listing',
    template: 'listing'
  };

  $stateProvider.state(home);
  $stateProvider.state(profile);
  $stateProvider.state(listing);
});

