app.service('AppService', function($http){
  let url = 'http://localhost:8000/api/';
  function newApp(data){
    return $http.post(url + 'app_register', data);
  }
  function deleteApp(id){
    return $http.delete(url + 'app_register/' + id);
  }
  function updateAppList(){
    return $http.get(url + 'app_register');
  }
  function showApp(profileId){
    return $http.get(url + 'app_register/' + profileId);
  }
  function updateApp(data, id){
    return $http.put(url + 'app_register/' + id, data);
  }
  function displayPresenceList(data){
    return $http.post(url + 'presence_list', data);
  }
  function getIndividualPresence(data){
    return $http.post(url + 'individual_presence', data);
  }
  function updateIndividualPresence(data, id){
    return $http.put(url + 'individual_presence/' + id, data);
  }
  
  return {
    newApp: newApp,
    deleteApp: deleteApp,
    updateAppList: updateAppList,
    showApp: showApp,
    updateApp: updateApp,
    displayPresenceList: displayPresenceList,
    getIndividualPresence: getIndividualPresence,
    updateIndividualPresence: updateIndividualPresence
  }
});