


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









dedSearchController.$inject = ['getJSON', '$scope'];
function dedSearchController(getJSON, $scope) {
    var self = this;
    self.searchId = 'dd';
    self.jsonList = [];

    alert($scope.searchId);


    getJSON.then(function(response){
        self.jsonList = response.data;
    });
}

