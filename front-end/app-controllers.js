app.controller('homeController', function($scope, $state, AppService){
  $scope.apprenants = [];
  $scope.newApp = _newApp;
  $scope.showApp = _showApp;
  
  function _newApp(){
    $scope.signature = $scope.accept();
    let data = {
      'nom': $scope.nom,
      'prenom': $scope.prenom,
      'avatar': 'data:' + $scope.avatar.filetype + ';base64,' + $scope.avatar.base64,
      'sign': $scope.signature.dataUrl,
    };
    AppService.newApp(data)
      .then(
        function(res){
          _updateListMod();
          alert(res.data.message);
        },
        function(res){
          alert('Something went wrong..');
        }
      );
  };

  function _showApp(id) {
    $state.go('profile', { profileId: id});
  }

  function _updateListMod() {
    AppService.updateListMod()
      .then(
        function (res) {
          $scope.apprenants = res.data;
        }
      );
  }

  _updateListMod();
});

app.controller('profileController', function($scope, $state, $stateParams, AppService){
  let profileId = $stateParams.profileId;
  $scope.deleteApp = _deleteApp;
  $scope.updateApp = _updateApp;
  $scope.avatar = null;
  $scope.sign = null;
  _signMod = false;
  _avatarMod = false;

  AppService.showApp(profileId)
    .then(
      function(res){
        $scope.apprenant = res.data;
        $scope.prenom = $scope.apprenant.first_name;
        $scope.nom = $scope.apprenant.last_name;
      },
      function(res){
        alert('Something went wrong..');
      }
    );

  function _deleteApp(id) {
    AppService.deleteApp(id)
      .then(
        function(res){
          $state.go('home');
        },
        function(res){
          alert('Something went wrong..');
        }
      );
  }

  function _updateApp(id){
    $scope.signature = $scope.accept();
    if ($scope.signature.dataUrl && !$scope.signature.isEmpty) {
      $scope.sign = $scope.signature.dataUrl;
      _signMod = true;
    } else {
      $scope.sign = null;
      _signMod = false;
    }
    if ($scope.avatar != null) {
      _avatarMod = true;
    } else {
      _avatarMod = false;
    }

    let data = {
      'nom': $scope.nom,
      'prenom': $scope.prenom,
      'avatar': null,
      'sign': null
    };
    if (_avatarMod) data.avatar = 'data:' + $scope.avatar.filetype + ';base64,' + $scope.avatar.base64;
    if (_signMod) data.sign = $scope.signature.dataUrl;

    AppService.updateApp(data, id)
      .then(
        function(res){
          console.log(res.data);
          $state.go('home');
        },
        function(res){
          alert('Something went wrong..');
        }
      );
  }
});