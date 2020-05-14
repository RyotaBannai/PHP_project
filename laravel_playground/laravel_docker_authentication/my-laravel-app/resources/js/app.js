require('./bootstrap');

window.Vue = require('vue');

Vue.component('example-component',
    require('./components/ExampleComponent.vue').default
);

Vue.component(
    'passport-clients',
    require('./components/passport/Clients').default
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens').default
);

const app = new Vue({
    el: '#app',
});
