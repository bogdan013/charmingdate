var dedProfile = angular.module('dedProfile');


dedProfile.component('dedProfile', {
    templateUrl: 'ded-profile/ded-profile.template.html',
    controller: DedProfileController
});


DedProfileController.$inject = ['$routeParams', '$scope'];
function DedProfileController($routeParams, $scope) {
    var self = this;
    self.profileId = $routeParams.profileId;
    
}