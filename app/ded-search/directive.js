angular.module('dedSearch').
    directive('searchFormTemp', searchFormTemp);


function searchFormTemp() {
    return {
        templateUrl: 'ded-search/ded-search.template.html'
    };
}