'use strict';

angular.module('charmApp').
config(['$locationProvider' ,'$routeProvider',
    function config($locationProvider, $routeProvider) {
        $locationProvider.hashPrefix('!');

        $routeProvider.
        when('/search', {
            template: '<ded-search></ded-search>'
        }).
        when('/profile/:profileId', {
            template: '<ded-profile></ded-profile>'
        }).
        otherwise('/search');
    }
]);