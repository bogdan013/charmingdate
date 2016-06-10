

angular.module('dedSearch').component('dedSearch', {
    templateUrl: 'ded-search/ded-search.template.html',

    controller: ['$http', function dedSearchController($http) {
        var self = this;

        self.searchId = 'CM';


        $http.get('serv/data.php').then(function(response){
            self.jsonList = response.data;

        });
    }]
}).filter('searchId', function(){



    return function (v, query) {
        return v.filter(function (i) {
            return i.manId.indexOf(query) > -1;
        });
    };
});