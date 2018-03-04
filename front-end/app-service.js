app.service('AppService', function($http){
  function newApp(data){
    return $http.post('http://localhost:8000/api/app_register', data);
  }
  function deleteApp(id){
    return $http.delete('http://localhost:8000/api/app_register/' + id);
  }
  function updateListMod(){
    return $http.get('http://localhost:8000/api/app_register');
  }
  function showApp(profileId){
    return $http.get('http://localhost:8000/api/app_register/' + profileId);
  }
  function updateApp(data, id){
    return $http.put('http://localhost:8000/api/app_register/' + id, data);
  }
  
  return {
    newApp: newApp,
    deleteApp: deleteApp,
    updateListMod: updateListMod,
    showApp: showApp,
    updateApp: updateApp
  }
});