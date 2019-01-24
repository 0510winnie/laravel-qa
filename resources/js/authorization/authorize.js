import policies from './policies';
// we want to call the method like this
// authorize('modify', answer); so we can modify vue.js prototype like this

export default {
    install (Vue, options) {
        Vue.prototype.authorize = function (policy, model) {
            if (! window.Auth.signedIn) return false;

            if (typeof policy === 'string' && typeof model === 'object') {
                const user = window.Auth.user;

                return policies[policy](user, model);
                //policies hold all methods in policies.js file
                //policies['modify'](user, model);
            }
        };

        Vue.prototype.signedIn = window.Auth.signedIn;
    }
}

