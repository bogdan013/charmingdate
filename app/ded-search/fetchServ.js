
angular.module('dedSearch').factory('fetchServ', fetchServ);

fetchServ.$inject = ['$http'];
function fetchServ($http) {
    return function() {
        return $http.get('serv/data.php');
    }
}