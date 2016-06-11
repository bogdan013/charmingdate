


angular.module('dedSearch').component('dedSearch', {
    templateUrl: 'ded-search/ded-search.template.html',
    controller: dedSearchController
}).filter('searchId', function(){
    return function (v, query) {
        return v.filter(function (i) {
            return i.manId.indexOf(query) > -1;
        });
    };
});




dedSearchController.$inject = ['$http'];
function dedSearchController($http) {
    var self = this;
    self.searchId = '';
    self.jsonList = [];

    $http.get('serv/data.php').then(function(response){
        self.jsonList = response.data;
    });
}

