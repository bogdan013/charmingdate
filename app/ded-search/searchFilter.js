angular.module('dedSearch').
    filter('searchFilter', searchFilter);


searchFilter.$inject = [];
function searchFilter() {
    return function(list, queryId, queryName, searchCase) {
        return list.filter(function(i){
            var idCondition = i.manId.indexOf(queryId) > -1;

            var nameInBase = i.fullName;

            if (searchCase == 1) {
                queryName = queryName.toLowerCase();
                nameInBase = nameInBase.toLowerCase();
            }
            var nameCondition = nameInBase.indexOf(queryName) > -1;

            return idCondition && nameCondition;
        });
    }
}