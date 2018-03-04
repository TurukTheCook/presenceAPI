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
    component: 'home',
  };
  var listing = {
    name: 'listing',
    url: '/listing',
    template: 'listing'
  };
  var profile = {
    name: 'profile',
    url: '/profile/{profileId}',
    component: 'profile',
    params: {
      apprenant: null,
    },
  };

  $stateProvider.state(home);
  $stateProvider.state(listing);
  $stateProvider.state(profile);
});

app.controller('homeController', function($scope, $http, $state){
  $scope.apprenants = [];
  $scope.addNewApp = addNewApp;
  $scope.deleteApp = deleteApp;
  $scope.showApp = showApp;
  
  function addNewApp(){
    var data = {
      'nom': $scope.nom,
      'prenom': $scope.prenom,
      'avatar': 'data:' + $scope.avatar.filetype + ';base64,' + $scope.avatar.base64,
      'sign': $scope.signature.dataUrl,
    };
    $http.post('http://localhost:8000/api/app_register', data)
      .then(
        function(res){
          updateListAppMod();
          alert(res.data.message);
        },
        function(res){
          alert('Something went wrong..');
        }
      );
  };

  function deleteApp(id) {
    $http.delete('http://localhost:8000/api/app_register/' + id)
      .then(
        function(res){
          alert(res.data.message);
          updateListAppMod();
        },
        function(res){
          alert('Something went wrong..');
        }
      );
  }

  function showApp(id) {
    $http.get('http://localhost:8000/api/app_register/' + id)
      .then(
        function(res){
          $state.go('profile', { profileId: id, apprenant: res.data });
        },
        function(res){
          alert('Something went wrong..');
        }
      );
  }

  function updateListAppMod() {
    $http.get('http://localhost:8000/api/app_register')
      .then(
        function (res) {
          $scope.apprenants = res.data;
        }
      );
  }

  updateListAppMod();
});

app.controller('profileController', function($scope, $http, $stateParams){
  $scope.apprenant = $stateParams.apprenant;
});

app.component('home', {
  templateUrl: 'components/home/home.html',
  controller: 'homeController',
});

app.component('profile', {
  templateUrl: 'components/profile/profile.html',
  controller: 'profileController',
});