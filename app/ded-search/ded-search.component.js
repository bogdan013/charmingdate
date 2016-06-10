var dedSearch = angular.module('dedSearch');

dedSearch.component('dedSearch', {
    templateUrl: 'ded-search/ded-search.template.html',
    controller: ['$http', function DedSearchController($http) {
        var self = this;
            self.searchId = '';
            self.jsonList = [];

        $http.get('serv/data.php').then(function(response){
            self.jsonList = response.data;
        });
        
    }]
});

dedSearch.filter('searchId', function(){
    return function (v, query) {
        return v.filter(function (i) {
            return i.manId.indexOf(query) > -1;
        });
    };
});