var dedProfile = angular.module('dedProfile');

dedProfile.component('dedProfile', {
    templateUrl: 'ded-profile/ded-profile.template.html',
    controller: ['$routeParams',
        function DedProfileController($routeParams) {
            var self = this;
            self.profileId = $routeParams.profileId;
        }
    ]
});
