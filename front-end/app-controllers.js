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
    AppService.updateAppList()
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
          $state.go('home');
        },
        function(res){
          alert('Something went wrong..');
        }
      );
  }
});

app.controller('listingController', function($scope, AppService){
  $scope.apprenants = [];
  $scope.presence_id = null;
  $scope.select = {};
  $scope.displayPresence = _displayPresence;
  $scope.updatePresenceMatin = _updatePresenceMatin;
  $scope.updatePresenceAprem = _updatePresenceAprem;
  $scope.openModalMatin = _openModalMatin;
  $scope.openModalAprem = _openModalAprem;
  $scope.PresentMatin = _PresentMatin;
  $scope.PresentAprem = _PresentAprem;
  $scope.AbsentMatin = _AbsentMatin;
  $scope.AbsentAprem = _AbsentAprem;
  $scope.modalId = null;


  $scope.formations = [
   'Formation Web Developpement'
  ];
  $scope.lieux = [
    'ICAM - Carré Sénart, 34 Points de Vue, 77127 Lieusaint'
  ];

  function _updateList() {
    AppService.updateAppList()
      .then(
        function (res) {
          $scope.apprenants = res.data;
        }
      );
  }

  function _findApprenantId(id) {
    let apprenant = $scope.apprenants.findIndex(function(element) {
      return element.id == id;
    });
  
    return apprenant;
  }

  function _displayPresence(){
    _updateList();

    let data = {
      'formation' : $scope.select.formation,
      'lieu' : $scope.select.lieu,
      'date' : $scope.select.date.toLocaleDateString(),
    };

    let apprenants = [];
    angular.forEach($scope.apprenants, function(value, key) {
      this.push(value.id);
    }, apprenants);
    
    AppService.displayPresenceList(data)
      .then(
        function(res){
          presence_id = res.data.id;
          let _data = {
            'presence_id': presence_id,
            'apprenants': apprenants
          };
          AppService.getIndividualPresence(_data)
            .then(
              function(res){
                let new_apps = res.data;
                angular.forEach(new_apps, function(value, key) {
                  let position = _findApprenantId(value.apprenant_id);
                  if(value.absent_matin == 0) $scope.apprenants[position].absentMatin = false;
                  else $scope.apprenants[position].absentMatin = true;
                  if(value.absent_aprem == 0) $scope.apprenants[position].absentAprem = false;
                  else $scope.apprenants[position].absentAprem = true;
                  _updatePresenceMatin($scope.apprenants[position].id, null);
                  _updatePresenceAprem($scope.apprenants[position].id, null);
                });
              },
              function(res){
                alert('Something went wrong..');
              }
            );
        },
        function(res){
          alert('Something went wrong..');
        }
      );
  }

  function _updatePresenceMatin(id, signatureUrl) {
    let _position = _findApprenantId(id);
    let absent = 1;

    if($scope.apprenants[_position].absentMatin == true) absent = 1;
    else absent = 0;

    let _data = {
      'absent': absent,
      'type': 'matin',
      'presence_id': presence_id,
      'sign': signatureUrl,
    };
    AppService.updateIndividualPresence(_data, id)
      .then(
        function(res){
          $scope.apprenants[_position].sign_matin = res.data.sign_matin;
        },
        function(res){
          alert('Something went wrong...');
        }
      );
  }

  function _updatePresenceAprem(id, signatureUrl) {
    let _position = _findApprenantId(id);
    let absent = 1;

    if($scope.apprenants[_position].absentAprem == true) absent = 1;
    else absent = 0;

    let _data = {
      'absent': absent,
      'type': 'aprem',
      'presence_id': presence_id,
      'sign': signatureUrl,
      'first_name': $scope.apprenants[_position].first_name,
      'last_name': $scope.apprenants[_position].last_name,
    };
    AppService.updateIndividualPresence(_data, id)
      .then(
        function(res){
          $scope.apprenants[_position].sign_aprem = res.data.sign_aprem;
        },
        function(res){
          alert('Something went wrong...');
        }
      );
  }

  function _PresentMatin(id) {
    let _position = _findApprenantId(id);
    $scope.apprenants[_position].absentMatin = false;
    $('#signModalMatin').modal('hide');
  }

  function _PresentAprem(id) {
    let _position = _findApprenantId(id);
    $scope.apprenants[_position].absentAprem = false;
    $('#signModalAprem').modal('hide');
  }

  function _AbsentMatin(id) {
    let _position = _findApprenantId(id);
    $scope.apprenants[_position].absentMatin = true;
    $('#signModalMatin').modal('hide');
  }

  function _AbsentAprem(id) {
    let _position = _findApprenantId(id);
    $scope.apprenants[_position].absentAprem = true;
    $('#signModalAprem').modal('hide');
  }

  function _openModalMatin(id){
    $('#signModalMatin').modal();
    $('#signModalMatin').on('shown.bs.modal', function (e) {
      $scope.modalId = id;
    });
  }

  function _openModalAprem(id){
    $('#signModalAprem').modal();
    $('#signModalAprem').on('shown.bs.modal', function (e) {
      $scope.modalId = id;
    });
  }

});