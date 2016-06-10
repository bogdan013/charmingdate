

angular.module('dedSearch').component('dedSearch', {
    templateUrl: 'ded-search/ded-search.template.html',

    controller: ['$http', function dedSearchController($http) {
        var self = this;

        $http.get('serv/data.php').then(function(response){
            self.jsonList = response.data;

        });
    }]
});